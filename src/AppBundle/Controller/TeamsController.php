<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Teams as Teams;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TeamsController extends Controller
{

    /**
     * @var array $tabDefinition Defines the default tab structure and feed
     */
    private $tabDefinition = array(
        'type' => 'teams',
        'name_label' => 'app.meta.title.tab.team',
        'name' => '',
        'id' => null,
        'active' => true,
        'action' => 'view',
        'tabs' => array(
            'main' => array(
                'id' => 'teams-tab',
                'collapseElementId' => 'teamsContent',
                'collapseElementDefaultState' => 'in',
                'headingText' => 'app.action.tab.main',
                'headingIcon' => 'fa-cog',
                'item' => null,
                'view_container_controller' => 'AppBundle:Teams:renderTeamView',
                'view_controller' => 'AppBundle:Teams:renderTeamView',
                'view_route' => 'team_fragment_view',
                'edit_controller' => 'AppBundle:Teams:renderTeamEdit',
                'edit_route' => 'team_fragment_edit',
            ),
            'related-people' => array(
                'id' => 'person-tab',
                'collapseElementId' => 'personContent',
                'collapseElementDefaultState' => '',
                'headingText' => 'app.action.tab.relatedPeople',
                'headingIcon' => 'fa-user',
                'item' => null,
                'view_container_controller' => 'AppBundle:Person:renderRelatedPeopleViewContainer',
                'view_controller' => 'AppBundle:Person:renderRelatedPeopleView',
                'view_route' => 'related_people_fragment_view',
                'edit_controller' => 'AppBundle:Person:renderPersonEdit',
                'edit_route' => 'person_fragment_edit',
            ),
            'related-projects' => array(
                'id' => 'projects-tab',
                'collapseElementId' => 'projectsContent',
                'collapseElementDefaultState' => '',
                'headingText' => 'app.action.tab.relatedProjects',
                'headingIcon' => 'fa-suitcase',
                'item' => null,
                'view_container_controller' => 'AppBundle:Projects:renderRelatedProjectsViewContainer',
                'view_controller' => 'AppBundle:Projects:renderRelatedProjectsView',
                'view_route' => 'related_projects_fragment_view',
                'edit_controller' => 'AppBundle:Projects:renderProjectEdit',
                'edit_route' => 'project_fragment_edit',
            )
        )
    );

    private $team;
    private $teamActive = true;
    private $teamActionMode = 'view';

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
        $this->tabDefinition['tabs']['related-projects']['headingText'] = $translatorService
            ->trans(
                $this->tabDefinition['tabs']['related-projects']['headingText'],
                array(),
                "messages"
            );
        $this->tabDefinition['tabs']['related-people']['headingText'] = $translatorService
            ->trans(
                $this->tabDefinition['tabs']['related-people']['headingText'],
                array(),
                "messages"
            );

        return $this->tabDefinition;
    }

    /**
     * @return array The tab definition array
     */
    private function fillInTabDefinition() {

        $this->tabDefinition['name']=$this->team->getInternationalName();
        $this->tabDefinition['id']=$this->team->getId();
        $this->tabDefinition['active']=$this->teamActive;
        $this->tabDefinition['action']=$this->teamActionMode;
        $this->tabDefinition['tabs']['main']['item']=$this->team;

        return $this->tabDefinition;
    }

    /**
     * @param $id
     * @return mixed
     */
    private function findTeam($id) {
        $team = $this->getDoctrine()
            ->getRepository('AppBundle:Teams')
            ->findOneById($id);
        return $team;
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function fillTeamInfos(Request $request) {

        $this->translateTabDefinition();
        $this->teamActive = true;
        $this->team = $this->findTeam( $request->get('id') );

        if ( $this->team === null ) {
            throw $this->createNotFoundException('The team does not exists.');
        }
        $currentTimestamp = new \DateTime();
        if ( $this->team->getEndDate() !== null && $this->team->getEndDate() < $currentTimestamp) {
            $this->teamActive = false;
        }
        $this->teamActionMode = $request->get('action');

        $this->fillInTabDefinition();

        return true;
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
        if ( $request->get('action') === 'add' ) {
            $this->team = new Teams();
        }
        elseif ( $this->fillTeamInfos($request) === false ) {
            throw $this->createNotFoundException('A problem occured initiating the team object.');
        }

        if ( $request->get('action') === 'view' ) {
            return $this->render(
                'default/tabbedContent.html.twig',
                $this->tabDefinition
            );
        }

        return $this->render('');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderTeamViewAction(Request $request) {
        if ( $this->fillTeamInfos($request) === false ) {
            throw $this->createNotFoundException('A problem occured initating the team object.');
        }

        return $this->render(
            '_partials/tabbedContent/mainTab/view/teams.html.twig',
            $this->tabDefinition
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderRelatedTeamsViewContainerAction(Request $request) {
        return $this->render(
            '_partials/tabbedContent/relatedTabs/view/teams.html.twig',
            array(
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
    public function renderRelatedTeamsViewAction(Request $request) {
        if( $request->get('type') != 'projects' && $request->get('type') != 'person' ) {
            throw $this->createNotFoundException('You cannot ask for related teams to something else than a project or a person');
        }

        $related_teams = array();

        if ( $request->get('id', 0) !== 0 ) {
            if ($request->get('type') === 'person') {
                $related_teams = $this->getDoctrine()
                                    ->getRepository('AppBundle:TeamsMembers')
                                    ->listTeams($request->get('id'), $request->getLocale());
            }
            else {
                $related_teams = $this->getDoctrine()
                    ->getRepository('AppBundle:TeamsProjects')
                    ->listTeams($request->get('id'),$request->getLocale());
            }
        }

        return $this->render(
            '_partials/tabbedContent/relatedTabs/view/related_teams.html.twig',
            array('related_teams' =>$related_teams,)
        );
    }
}
