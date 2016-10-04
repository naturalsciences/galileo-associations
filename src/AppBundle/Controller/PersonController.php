<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PersonController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function personListAction(Request $request)
    {
        return $this->render('');
    }
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function personAction(Request $request)
    {
        if ( $request->get('action') === 'view' ) {
            return $this->render('/default/tabbedContent.html.twig');
        }
        return $this->render('');
    }
}
