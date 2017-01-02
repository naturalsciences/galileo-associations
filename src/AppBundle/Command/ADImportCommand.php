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
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ADImportCommand extends DoctrineCommand
{

    /**
     * @var EntityManager The entity manager to interact with Database and ADSync table
     */
    private $em;
    /**
     * @var Adldap The adldap instance to interact with the Active Directory
     */
    private $ldap;
    /**
     * @var string The list of uid to renew
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
     * @inheritDoc
     */
    protected function configure()
    {
        $this
            ->setName('rbins:ad:import')
            ->setDescription('Import (or reimport) all users from Active Directory into the ADSync table')
            ->addOption('uid',null,InputOption::VALUE_REQUIRED, 'An optional list of user identifiers to re-import')
            ->addOption('em',null,InputOption::VALUE_REQUIRED,'The entity manager to use for this command','default')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command import or re-import all users from the Active Directory configured:

    <info>php %command.full_name%</info>

You can also optionally specify a list of users id you wish to overwrite - each one separated by a comma:

    <info>php %command.full_name% --uid=uid1,uid2,...</info>
EOT
            );
    }

    /**
     * @inheritDoc
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->formatter = $this->getHelper('formatter');
        try {
            $this->em = $this->getContainer()->get('doctrine')->getManager();
/*            $this->em = $this->getEntityManager($input->getOption('em'));*/
            $this->ldap = $this->getContainer()->get('adldap2');
            $this->sammacountnames = explode(',',$input->getOption('uid'));
            $this->batchSize = 20;
        }
        catch (\Exception $e) {
            $formattedBlock = $this->formatter->formatBlock("An error occured: $e", 'error');
            $output->writeln($formattedBlock);
        }
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $ldapUser = $this->ldap->getDefaultProvider()
                ->search()
                ->users()
                ->select('samaccountname', 'sn', 'givenname', 'mail', 'othermailbox', 'userprincipalname')
                ->rawFilter("(&(objectClass=Person)(!(zarafaresourcetype=room))(mail=*)(sAMAccountName=*)(!(memberOf=CN=NotForWebUsers,CN=Users,DC=rbins,DC=be)))")
                ->get()->toArray();
            $counting = 1;
            foreach ($ldapUser as $user) {
                $adSync = new ADSync();
                $adSync->setSamaccountname($user['samaccountname']);
                $adSync->setSn($user['sn'][0]);
                $adSync->setGivenname($user['givenname']);
                $adSync->setMail($user['mail']);
                $adSync->setOthermail($user['othermailbox']);
                $adSync->setUserprincipalname($user['userprincipalname']);
                $this->em->persist($adSync);
                if (($counting % $this->batchSize) === 0) {
                    $this->em->flush();
                    $this->em->clear();
                }
                $counting += 1;
            }
            $this->em->flush();
            $this->em->clear();
        }
        catch (\Exception $e) {
            $formattedBlock = $this->formatter->formatBlock("An error occured: $e", 'error');
            $output->writeln($formattedBlock);
        }
    }

}