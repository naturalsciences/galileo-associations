<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PersonController extends Controller
{

    /**
     * @var array $tabDefinition Defines the default tab structure and feed
     */
    private $tabDefinition = array(
        'type' => 'person',
        'name_label' => 'app.meta.title.tab.person',
        'name' => '',
        'id' => null,
        'active' => true,
        'action' => 'view',
        'tabs' => array(
            'main' => array(
                'id' => 'person-tab',
                'collapseElementId' => 'personContent',
                'collapseElementDefaultState' => 'in',
                'headingText' => 'app.action.tab.main',
                'headingIcon' => 'fa-cog',
                'item' => null,
                'form' => null,
                'view_container_controller' => 'AppBundle:Person:renderPersonView',
                'view_controller' => 'AppBundle:Person:renderPersonView',
                'view_route' => 'person_fragment_view',
                'edit_controller' => 'AppBundle:Person:renderPersonEdit',
                'edit_route' => 'person_fragment_edit',
            ),
            'related-teams' => array(
                'id' => 'teams-tab',
                'collapseElementId' => 'teamsContent',
                'collapseElementDefaultState' => '',
                'headingText' => 'app.action.tab.relatedTeams',
                'headingIcon' => 'fa-users',
                'item' => null,
                'form' => null,
                'view_container_controller' => 'AppBundle:Teams:renderRelatedTeamsViewContainer',
                'view_controller' => 'AppBundle:Teams:renderRelatedTeamsView',
                'view_route' => 'related_teams_fragment_view',
                'edit_controller' => 'AppBundle:Teams:renderTeamEdit',
                'edit_route' => 'team_fragment_edit',
            ),
            'related-projects' => array(
                'id' => 'projects-tab',
                'collapseElementId' => 'projectsContent',
                'collapseElementDefaultState' => '',
                'headingText' => 'app.action.tab.relatedProjects',
                'headingIcon' => 'fa-suitcase',
                'item' => null,
                'form' => null,
                'view_container_controller' => 'AppBundle:Projects:renderRelatedProjectsViewContainer',
                'view_controller' => 'AppBundle:Projects:renderRelatedProjectsView',
                'view_route' => 'related_projects_fragment_view',
                'edit_controller' => 'AppBundle:Projects:renderProjectEdit',
                'edit_route' => 'project_fragment_edit',
            )
        )
    );

    private $person;
    private $personActive = true;
    private $personActionMode = 'view';

    /**
     * @return array Return the tab definition array with the necessary parts translated
     */
    private function translateTabDefinition() {

        $translatorService = $this->get('translator');
        $this->tabDefinition['name_label'] = $translatorService
            ->trans(
                $this->tabDefinition['name_label'],
                array(),
                "messages"
            );
        $this->tabDefinition['tabs']['main']['headingText'] = $translatorService
            ->trans(
                $this->tabDefinition['tabs']['main']['headingText'],
                array(),
                "messages"
            );
        $this->tabDefinition['tabs']['related-teams']['headingText'] = $translatorService
            ->trans(
                $this->tabDefinition['tabs']['related-teams']['headingText'],
                array(),
                "messages"
            );
        $this->tabDefinition['tabs']['related-projects']['headingText'] = $translatorService
            ->trans(
                $this->tabDefinition['tabs']['related-projects']['headingText'],
                array(),
                "messages"
            );

        return $this->tabDefinition;
    }

    /**
     * @return array The tab definition array
     */
    private function fillInTabDefinition() {

        $this->tabDefinition['name']=trim($this->person->getFirstName().' '.$this->person->getLastName());
        $this->tabDefinition['id']=$this->person->getId();
        $this->tabDefinition['active']=$this->personActive;
        $this->tabDefinition['action']=$this->personActionMode;
        $this->tabDefinition['tabs']['main']['item']=$this->person;

        return $this->tabDefinition;
    }

    /**
     * @param int $id Identifier of person
     * @return mixed Return the person object if found
     */
    private function findPerson($id) {
        $person = $this->getDoctrine()
            ->getRepository('AppBundle:Person')
            ->findOneById($id);
        return $person;
    }

    /**
     * @param int $id Identifier of Person
     * @return mixed Return data from person entry table if the person is active, otherwise null
     */
    private function isActive($id) {
        $personEntry = $this->getDoctrine()
            ->getRepository('AppBundle:PersonEntry')
            ->isActive($id);
        return $personEntry;
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function fillPersonInfos(Request $request) {

        $this->translateTabDefinition();
        $this->person = $this->findPerson( $request->get('id') );

        if ( $this->person === null ) {
            throw $this->createNotFoundException('The person does not exists.');
        }
        $this->personActive = $this->isActive($this->person->getId());
        $this->personActionMode = $request->get('action');

        $this->fillInTabDefinition();

        return true;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function personListAction(Request $request)
    {
        $personGroupsLetter = $this->getDoctrine()
            ->getRepository('AppBundle:Person')
            ->groupsByLetters($request->getLocale());
        return $this->render(
            'default/personProjectsAndTeamsList.html.twig',
            array(
                'type'=>'person',
                'groupsLetter' =>$personGroupsLetter
            )
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function personListDetailAction(Request $request)
    {
        $personGroupsLetter = $this->getDoctrine()
            ->getRepository('AppBundle:Person')
            ->groupsByLetters($request->getLocale(), $request->get('letter'));
        return $this->render(
            '_partials/listContent/letterDetails.html.twig',
            array(
                'type'=>'person',
                'groupsLetter' =>$personGroupsLetter
            )
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function personAction(Request $request)
    {
        if ( $this->fillPersonInfos($request) === false ) {
            throw $this->createNotFoundException('A problem occured initiating the person object.');
        }

        return $this->render(
            'default/tabbedContent.html.twig',
            $this->tabDefinition
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderPersonViewAction(Request $request) {
        if ( $this->fillPersonInfos($request) === false ) {
            throw $this->createNotFoundException('A problem occured initiating the person object.');
        }

        $this->tabDefinition['action'] = 'view';

        return $this->render(
            '_partials/tabbedContent/mainTab/view/person.html.twig',
            $this->tabDefinition
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderRelatedPeopleViewContainerAction(Request $request) {
        return $this->render(
            '_partials/tabbedContent/relatedTabs/view/people.html.twig',
            array (
                'id' => $request->get('id'),
                'view_controller' => $request->get('view_controller'),
                'view_route' => $request->get('view_route'),
                'edit_controller' => $request->get('edit_controller'),
                'edit_route' => $request->get('edit_route'),
                'type' => $request->get('type'),
            )
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderRelatedPeopleViewAction(Request $request) {
        if( $request->get('type') != 'teams' && $request->get('type') != 'projects' ) {
            throw $this->createNotFoundException('You cannot ask for related people to something else than a team or a project');
        }

        $related_people = array();
        ($request->get('type')=='teams')?$type='TeamsMembers':$type='ProjectsMembers';

        if ( $request->get('id', 0) !== 0 ) {
            if ($request->get('type') === 'teams') {
                $related_people = $this->getDoctrine()
                    ->getRepository('AppBundle:TeamsMembers')
                    ->listMembers($request->get('id'));
            }
            else {
                $related_people = $this->getDoctrine()
                    ->getRepository('AppBundle:ProjectsMembers')
                    ->listMembers($request->get('id'));
            }
        }

        return $this->render(
            '_partials/tabbedContent/relatedTabs/view/related_people.html.twig',
            array( 'related_people' => $related_people, 'type' => $type )
        );
    }
}
