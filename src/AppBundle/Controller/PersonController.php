<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PersonController extends Controller
{
    /**
     * @param $id
     * @return mixed
     */
    private function findPerson($id) {
        $person = $this->getDoctrine()
            ->getRepository('AppBundle:Person')
            ->findOneById($id);
        return $person;
    }

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
        if ( $request->get('action') === 'add' ) {
            $person = new Person();
        }
        else {
            $person = $this->findPerson( $request->get('id') );
            if ( $person === null ) {
                throw $this->createNotFoundException('The person does not exists.');
            }
        }

        if ( $request->get('action') === 'view' ) {
            return $this->render(
                '/default/tabbedContent.html.twig',
                array(
                    'tabs' => array(
                        'main' => array(
                            'id' => 'person',
                            'collapseElementId' => 'personContent',
                            'collapseElementDefaultState' => 'in',
                            'headingText' => 'Main',
                            'headingIcon' => 'fa-cog',
                            'items' => $person,
                            'items-displayed-fields' => array(
                                'First name' =>'first_name',
                                'Last name' => 'last_name',
                                'Email' => 'email'
                            )
                        ),
                        'related-teams' => array(
                            'id' => 'teams',
                            'collapseElementId' => 'teamsContent',
                            'collapseElementDefaultState' => '',
                            'headingText' => 'Related Teams',
                            'headingIcon' => 'fa-users',
                            'items' => $person->getTeamsMembers(),
                            'items-displayed-fields' => array(
                            )
                        ),
                        'related-projects' => array(
                            'id' => 'projects',
                            'collapseElementId' => 'projectsContent',
                            'collapseElementDefaultState' => '',
                            'headingText' => 'Related Projects',
                            'headingIcon' => 'fa-suitcase',
                            'items' => $person->getProjectsMembers(),
                            'items-displayed-fields' => array(
                            )
                        )
                    )
                )
            );
        }

        return $this->render('');
    }
}
