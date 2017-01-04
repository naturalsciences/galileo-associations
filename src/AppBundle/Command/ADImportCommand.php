<?php
/**
 * Created by PhpStorm.
 * User: duchesne
 * Date: 2/01/17
 * Time: 11:39
 */

namespace AppBundle\Command;

use Adldap\Adldap;
use AppBundle\Entity\ADSync;
use Doctrine\Bundle\DoctrineBundle\Command\DoctrineCommand;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ADImportCommand extends DoctrineCommand
{
    use LockableTrait;
    /**
     * @var EntityManager The entity manager to interact with Database and ADSync table
     */
    private $em;
    /**
     * @var Adldap The adldap instance to interact with the Active Directory
     */
    private $ldap;
    /**
     * @var string[] The list of uid to renew
     */
    private $sammacountnames;
    /**
     * @var integer The Size used for Batch/Bulk Doctrine Insert
     */
    private $batchSize;
    /**
     * @var mixed The Formatter Helper
     */
    private $formatter;

    /**
     * @return string The samaccountname filter that needs to be passed when issueing a ldap search for users
     */
    private function constructSamaccountnameFilter() {
        // By default filter on samaccountname is every record that has got a samaccountname field filled
        $samaccountnameFilter = '(samaccountname=*)';
        // If uid asked, then construct the filter with OR
        if ( $this->sammacountnames[0] !== '' ) {
            $samaccountnameFilter = '(|';
            foreach ( $this->sammacountnames as $sammacountname ) {
                $samaccountnameFilter.='(samaccountname='.ldap_escape($sammacountname, null, LDAP_ESCAPE_FILTER).')';
            }
            $samaccountnameFilter.=')';
        }
        return $samaccountnameFilter;
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this
            ->setName('rbins:ad:import')
            ->setDescription('Import (or reimport) all users from Active Directory into the ADSync table')
            ->addOption('uid',null,InputOption::VALUE_REQUIRED, 'An optional list of user identifiers to re-import')
            ->addOption('simple-message', null, InputOption::VALUE_NONE, 'Tells if wished to have shorten output message')
            ->addOption('em',null,InputOption::VALUE_REQUIRED,'The entity manager to use for this command','default')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command import or re-import all users from the Active Directory configured:

    <info>php %command.full_name%</info>

You can also optionally specify a list of users id you wish to overwrite - each one separated by a comma:

    <info>php %command.full_name% --uid=uid1,uid2,...</info>

You can also optionally specify to get output as simple message: OK if everything went well KO if not

    <info>php %command.full_name% --simple-message</info>
EOT
            );
    }

    /**
     * @inheritDoc
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        // Initialize all common vars
        $this->formatter = $this->getHelper('formatter');
        try {
            $this->em = $this->getEntityManager($input->getOption('em'));
            $this->ldap = $this->getContainer()->get('adldap2');
            $this->sammacountnames = explode(',',$input->getOption('uid'));
            $this->batchSize = 200;
        }
        catch (\Exception $e) {
            $formattedBlock = $this->formatter->formatBlock("An error occured: $e", 'error');
            $output->writeln($formattedBlock);
            return 0;
        }
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Test if a lock is already set in place by the same execution elsewhere
        if (!$this->lock()) {
            if ($input->getOption('simple-message')) {
                $output->writeln('KO');
            }
            else {
                $output->writeln('The command is already running in another process.');
            }
            return 0;
        }
        try {
            // Initialize some vars
            $ldapBaseDN = $this->getContainer()->getParameter('ldap_base_dn');
            $samaccountnameFilter = $this->constructSamaccountnameFilter();
            // Query the ldap with filter to get the list of users
            $ldapUser = $this->ldap->getDefaultProvider()
                ->search()
                ->users()
                ->select('samaccountname', 'sn', 'givenname', 'mail', 'othermailbox', 'userprincipalname')
                ->rawFilter("(&(objectClass=Person)(!(zarafaresourcetype=room))(mail=*)$samaccountnameFilter(!(memberOf=CN=NotForWebUsers,CN=Users,$ldapBaseDN)))")
                ->get()->toArray();
            // Initialize counting vars
            $counting = 0;
            $ldapUserCount = count($ldapUser);
            if ( $ldapUserCount > 0) {
                $this->em->beginTransaction();
                // First delete necessary records (all or the ones defined with the option --uid)
                $qb = $this->em->createQueryBuilder()->delete('AppBundle:ADSync', 'ad');
                if ( $this->sammacountnames[0] !== '' && $samaccountnameFilter !== '(samaccountname=*)') {
                    $qb->andWhere($qb->expr()->in('ad.samaccountname', $this->sammacountnames));
                }
                $qb->getQuery()->execute();
                if (!$input->getOption('simple-message')) {
                    // Initialize progress bar
                    $progress = new ProgressBar($output, $ldapUserCount);
                    $progress->start();
                }
                // Insert by loop all ldap users retrieved with necessary informations for adsync table
                foreach ($ldapUser as $user) {
                    $adSync = new ADSync();
                    $adSync->setSamaccountname((string)$user['samaccountname'][0]);
                    $adSync->setGivenname((string)$user['givenname'][0]);
                    $adSync->setMail((string)$user['mail'][0]);
                    $adSync->setSn((string)$user['sn'][0]);
                    $adSync->setOthermail((string)$user['othermailbox'][0]);
                    $adSync->setUserprincipalname((string)$user['userprincipalname'][0]);
                    $this->em->persist($adSync);
                    // Do batch insertion depending the value of $this->batchSize
                    if ($counting > 0 && ($counting % $this->batchSize) === 0) {
                        $this->em->flush();
                        $this->em->clear();
                    }
                    if (!$input->getOption('simple-message')) {
                        $progress->advance();
                    }
                    $counting += 1;
                }
                // Insert the remaining
                $this->em->flush();
                $this->em->clear();
                $this->em->commit();
                if (!$input->getOption('simple-message')) {
                    $progress->finish();
                }
            }
            if (!$input->getOption('simple-message')) {
                $formattedBlock = $this->formatter->formatBlock("Successfully renewed " . $counting . ' records', 'info');
            }
            else {
                $formattedBlock = 'OK';
            }
        }
        catch (\Exception $e) {
            if (!$input->getOption('simple-message')) {
                $formattedBlock = $this->formatter->formatBlock("An error occured: $e", 'error');
            }
            else {
                $formattedBlock = 'KO';
            }
        }
        $this->release();
        $output->writeln($formattedBlock);
    }

}
