<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TeamsController extends Controller
{
    /**
     * @param $id
     * @return mixed
     */
    private function findPerson($id) {
        $team = $this->getDoctrine()
            ->getRepository('AppBundle:Teams')
            ->findOneById($id);
        return $team;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function teamsListAction(Request $request)
    {
        return $this->render('');
    }
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function teamsAction(Request $request)
    {
        return $this->render('');
    }
}
