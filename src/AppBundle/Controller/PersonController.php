<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PersonController extends Controller
{

    /**
     * @var array $tabDefinition Defines the default tab structure and feed
     */
    private $tabDefinition = array(
        'type' => 'person',
        'name_label' => 'Person',
        'name' => '',
        'id' => null,
        'tabs' => array(
            'main' => array(
                'id' => 'person-tab',
                'collapseElementId' => 'personContent',
                'collapseElementDefaultState' => 'in',
                'headingText' => 'Main',
                'headingIcon' => 'fa-cog',
                'items' => null,
                'template_path' => '_partials/tabbedContent/mainTab/view/person.html.twig'
            ),
            'related-teams' => array(
                'id' => 'teams-tab',
                'collapseElementId' => 'teamsContent',
                'collapseElementDefaultState' => '',
                'headingText' => 'Related Teams',
                'headingIcon' => 'fa-users',
                'items' => null,
                'template_path' => '_partials/tabbedContent/relatedTabs/view/teams.html.twig'
            ),
            'related-projects' => array(
                'id' => 'projects-tab',
                'collapseElementId' => 'projectsContent',
                'collapseElementDefaultState' => '',
                'headingText' => 'Related Projects',
                'headingIcon' => 'fa-suitcase',
                'items' => null,
                'template_path' => '_partials/tabbedContent/relatedTabs/view/projects.html.twig'
            )
        )
    );

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

            $this->tabDefinition['name']=trim($person->getFirstName().' '.$person->getLastName());
            $this->tabDefinition['id']=$person->getId();
            $this->tabDefinition['tabs']['main']['items']=$person;
            $this->tabDefinition['tabs']['related-teams']['items']=$person->getTeamsMembers();
            $this->tabDefinition['tabs']['related-projects']['items']=$person->getProjectsMembers();
            
            return $this->render(
                '/default/tabbedContent.html.twig',
                $this->tabDefinition
            );
        }

        return $this->render('');
    }
}
