<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\SecurityFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $securityForm = $this->createForm(
            SecurityFormType::class,
            array(
                '_username' => $lastUsername,
            )
        );

        return $this->render('security/login.html.twig', array(
            'form' => $securityForm->createView(),
            'error'         => $error,
        ));
    }
}
