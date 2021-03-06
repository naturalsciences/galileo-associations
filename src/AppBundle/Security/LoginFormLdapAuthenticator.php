<?php
/**
 * Created by PhpStorm.
 * User: duchesne
 * Date: 6/12/16
 * Time: 14:59
 */

namespace AppBundle\Security;


use Adldap\Contracts\AdldapInterface;
use AppBundle\Entity\Person;
use AppBundle\Form\Type\SecurityFormType;
use Doctrine\DBAL\Types\JsonArrayType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Ldap\Adapter\ExtLdap\Connection;
use Symfony\Component\Ldap\LdapInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\LdapUserProvider;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormLdapAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var UserPasswordEncoder
     */
    private $passwordEncoder;
    /**
     * @var LdapUserProvider
     */
    private $ldapUser;
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var LdapBindAuthentication
     */
    private $ldapBindAuth;
    /**
     * @var AdldapInterface
     */
    private $adldap;

    /**
     * LoginFormAuthenticator constructor.
     * @param FormFactoryInterface $formFactory
     * @param LdapUserProvider $ldapUser
     * @param EntityManager $em
     * @param RouterInterface $router
     * @param UserPasswordEncoder $passwordEncoder
     * @param UserCheckerInterface $userChecker
     * @param LdapInterface $ldap
     * @param Connection $ldapConnection
     * @param AdldapInterface $adldap
     * @internal param KernelInterface $kernelInterface
     */
    public function __construct(FormFactoryInterface $formFactory, LdapUserProvider $ldapUser, EntityManager $em, RouterInterface $router, UserPasswordEncoder $passwordEncoder, UserCheckerInterface $userChecker, LdapInterface $ldap, Connection $ldapConnection, AdldapInterface $adldap)
    {
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->passwordEncoder = $passwordEncoder;
        $this->ldapUser = $ldapUser;
        $this->em = $em;
        $this->ldapBindAuth = new LdapBindAuthentication($ldapUser,$userChecker,'ldap_users', $ldap);
        $this->adldap = $adldap;
    }


    /**
     * Get the authentication credentials from the request and return them
     * as any type (e.g. an associate array). If you return null, authentication
     * will be skipped.
     *
     * Whatever value you return here will be passed to getUser() and checkCredentials()
     *
     * For example, for a form login, you might:
     *
     *      if ($request->request->has('_username')) {
     *          return array(
     *              'username' => $request->request->get('_username'),
     *              'password' => $request->request->get('_password'),
     *          );
     *      } else {
     *          return;
     *      }
     *
     * Or for an API token that's on a header, you might use:
     *
     *      return array('api_key' => $request->headers->get('X-API-TOKEN'));
     *
     * @param Request $request
     *
     * @return mixed|null
     */
    public function getCredentials(Request $request)
    {
        $isLoginSubmit = in_array($request->getPathInfo(), array('/en/login', '/fr/login', '/nl/login')) && $request->isMethod('POST');
        if (! $isLoginSubmit) {
            return null;
        }

        $form = $this->formFactory->create(SecurityFormType::class);
        $form->handleRequest($request);
        $data = $form->getData();

        $request->getSession()->set(
            Security::LAST_USERNAME,
            $data['_username']
        );

        return $data;

    }

    /**
     * Return a UserInterface object based on the credentials.
     *
     * The *credentials* are the return value from getCredentials()
     *
     * You may throw an AuthenticationException if you wish. If you return
     * null, then a UsernameNotFoundException is thrown for you.
     *
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     *
     * @throws AuthenticationException
     *
     * @return UserInterface|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials['_username'];
        $dbUser = $this->em->getRepository('AppBundle:Person')
            ->findOneBy(array('uid' => $username));

        return $dbUser;
    }

    /**
     * Returns true if the credentials are valid.
     *
     * If any value other than true is returned, authentication will
     * fail. You may also throw an AuthenticationException if you wish
     * to cause authentication to fail.
     *
     * The *credentials* are the return value from getCredentials()
     *
     * @param mixed $credentials
     * @param UserInterface $user
     *
     * @return bool
     *
     * @throws AuthenticationException
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        $password = $credentials['_password'];
        $username = $user->getUsername();
        $defaultUserRoles = $user->getDefaultApplicationRoles();
        try {
            if ($this->ldapBindAuth->verifyAuthentication($username, $password) === true) {
                $ldapUser = $this->adldap->getDefaultProvider()->search()->users()->select('dn')->rawFilter("(samaccountname=$username)")->get()->toArray();
                $ldapUserDn = $ldapUser[0]['dn'];
                $ldapGroup = $this->adldap->getDefaultProvider()->search()->groups()->select('name')->rawFilter("(member:1.2.840.113556.1.4.1941:=$ldapUserDn)")->get()->toArray();
                $ldapGroups = array();
                foreach ($ldapGroup as $group) {
                    $ldapGroups[] = $group['name'][0];
                }
                if (count($ldapGroups) > 0) {
                    $ldapGroups = array_unique(array_merge($ldapGroups, $defaultUserRoles));
                    $user->setRoles($ldapGroups);
                }
                $user->setPlainPassword($password);
                $this->em->persist($user);
                $this->em->flush($user);
                return true;
            }
        }
        catch (\Exception $e){
            try {
                if ($this->ldapUser->loadUserByUsername($credentials['_username'])) {
                    return false;
                }
            }
            catch (\Exception $exception) {
                if($this->passwordEncoder->isPasswordValid($user, $password)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Return the URL to the login page.
     *
     * @return string
     */
    protected function getLoginUrl()
    {
        return $this->router->generate('app_login');
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $targetPath = null;

        // if the user hit a secure page and start() was called, this was
        // the URL they were on, and probably where you want to redirect to
        if ($request->getSession() instanceof SessionInterface) {
            $targetPath = $this->getTargetPath($request->getSession(), $providerKey);
        }

        if (!$targetPath) {
            $targetPath = $this->router->generate('app_homepage');
        }

        return new RedirectResponse($targetPath);

    }


}
