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
        'active' => true,
        'tabs' => array(
            'main' => array(
                'id' => 'person-tab',
                'collapseElementId' => 'personContent',
                'collapseElementDefaultState' => 'in',
                'headingText' => 'Main',
                'headingIcon' => 'fa-cog',
                'item' => null,
                'template_path' => '_partials/tabbedContent/mainTab/view/person.html.twig'
            ),
            'related-teams' => array(
                'id' => 'teams-tab',
                'collapseElementId' => 'teamsContent',
                'collapseElementDefaultState' => '',
                'headingText' => 'Related Teams',
                'headingIcon' => 'fa-users',
                'item' => null,
                'template_path' => '_partials/tabbedContent/relatedTabs/view/teams.html.twig'
            ),
            'related-projects' => array(
                'id' => 'projects-tab',
                'collapseElementId' => 'projectsContent',
                'collapseElementDefaultState' => '',
                'headingText' => 'Related Projects',
                'headingIcon' => 'fa-suitcase',
                'item' => null,
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
     * @param $id
     * @return mixed
     */
    private function getIsActive($id) {
        $personEntry = $this->getDoctrine()
            ->getRepository('AppBundle:PersonEntry')
            ->isActive($id);
        return $personEntry;
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
        $isActive = true;
        if ( $request->get('action') === 'add' ) {
            $person = new Person();
        }
        else {
            $person = $this->findPerson( $request->get('id') );
            if ( $person === null ) {
                throw $this->createNotFoundException('The person does not exists.');
            }
            $isActive = $this->getIsActive($person->getId());
        }

        if ( $request->get('action') === 'view' ) {

            $this->tabDefinition['name']=trim($person->getFirstName().' '.$person->getLastName());
            $this->tabDefinition['id']=$person->getId();
            $this->tabDefinition['active']=$isActive;
            $this->tabDefinition['tabs']['main']['item']=$person;

            return $this->render(
                '/default/tabbedContent.html.twig',
                $this->tabDefinition
            );
        }

        return $this->render('');
    }
}
