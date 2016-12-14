<?php
/**
 * Created by PhpStorm.
 * User: duchesne
 * Date: 13/12/16
 * Time: 11:04
 */

namespace AppBundle\Security;

use Symfony\Component\Ldap\Exception\ConnectionException;
use Symfony\Component\Ldap\LdapInterface;
use Symfony\Component\Security\Core\Authentication\Provider\LdapBindAuthenticationProvider;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Yaml\Yaml;

class LdapBindAuthentication extends LdapBindAuthenticationProvider
{

    /**
     * @var UserProviderInterface
     */
    private $userProvider;
    /**
     * @var LdapInterface
     */
    private $ldap;
    /**
     * @var string
     */
    private $dnString;

    /**
     * LdapBindAuthentication constructor.
     * @param UserProviderInterface $userProvider
     * @param UserCheckerInterface $userChecker
     * @param string $providerKey
     * @param LdapInterface $ldap
     * @param string $dnString
     * @param bool $hideUserNotFoundExceptions
     */
    public function __construct(UserProviderInterface $userProvider, UserCheckerInterface $userChecker, $providerKey, LdapInterface $ldap, $dnString = '{username}', $hideUserNotFoundExceptions = true)
    {
        $userDomain = '';
        try {
            $container = $GLOBALS['kernel']->getContainer();
            $kernel = $container->get('kernel');
            $rootDir = $kernel->getRootDir();
            $parameters = Yaml::parse(file_get_contents($rootDir . '/config/parameters.yml'));
            $userDomain = (isset($parameters['parameters']['ldap_user_domain']))?'@'.$parameters['parameters']['ldap_user_domain']:'';
        }
        catch (\Exception $e) {}
        $this->userProvider = $userProvider;
        $this->ldap = $ldap;
        $this->dnString = $dnString.$userDomain;
        parent::__construct($this->userProvider, $userChecker,$providerKey,$this->ldap,$this->dnString,$hideUserNotFoundExceptions);
    }

    /**
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function verifyAuthentication($username, $password)
    {
        if ('' === $password) {
            throw new BadCredentialsException('The presented password must not be empty.');
        }

        try {
            $username = $this->ldap->escape($username, '', LdapInterface::ESCAPE_DN);
            $dn = str_replace('{username}', $username, $this->dnString);
            $this->ldap->bind($dn, $password);
        } catch (ConnectionException $e) {
            throw new BadCredentialsException('The presented password is invalid.');
        }
        return true;
    }

}
