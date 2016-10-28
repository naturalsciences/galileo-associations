<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Projects as Projects;
use AppBundle\Form\Type\ProjectsFormType as ProjectsFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProjectsController extends Controller
{

    /**
     * @var array $tabDefinition Defines the default tab structure and feed
     */
    private $tabDefinition = array(
        'type' => 'projects',
        'name_label' => 'app.meta.title.tab.project',
        'name' => '',
        'id' => null,
        'active' => true,
        'action' => 'view',
        'tabs' => array(
            'main' => array(
                'id' => 'projects-tab',
                'collapseElementId' => 'projectsContent',
                'collapseElementDefaultState' => 'in',
                'headingText' => 'app.action.tab.main',
                'headingIcon' => 'fa-cog',
                'item' => null,
                'form' => null,
                'view_container_controller' => 'AppBundle:Projects:renderProjectView',
                'view_controller' => 'AppBundle:Projects:renderProjectView',
                'view_route' => 'project_fragment_view',
                'edit_controller' => 'AppBundle:Projects:renderProjectEdit',
                'edit_route' => 'project_fragment_edit',
            ),
            'related-people' => array(
                'id' => 'person-tab',
                'collapseElementId' => 'personContent',
                'collapseElementDefaultState' => '',
                'headingText' => 'app.action.tab.relatedPeople',
                'headingIcon' => 'fa-user',
                'item' => null,
                'form' => null,
                'view_container_controller' => 'AppBundle:Person:renderRelatedPeopleViewContainer',
                'view_controller' => 'AppBundle:Person:renderRelatedPeopleView',
                'view_route' => 'related_people_fragment_view',
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
            )
        )
    );

    private $project;
    private $projectActive;
    private $projectActionMode;

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

        $this->tabDefinition['name']=$this->project->getInternationalName();
        $this->tabDefinition['id']=$this->project->getId();
        $this->tabDefinition['active']=$this->projectActive;
        $this->tabDefinition['action']=$this->projectActionMode;
        $this->tabDefinition['tabs']['main']['item']=$this->project;

        return $this->tabDefinition;
    }

    /**
     * @param $id
     * @return mixed
     */
    private function findProject($id) {
        $project = $this->getDoctrine()
            ->getRepository('AppBundle:Projects')
            ->findOneById($id);
        return $project;
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function fillProjectInfos(Request $request) {

        $this->projectActive = true;
        $this->project = $this->findProject( $request->get('id') );

        if ( $this->project === null ) {
            throw $this->createNotFoundException('The project does not exists.');
        }
        $currentTimestamp = new \DateTime();
        if ( $this->project->getEndDate() !== null && $this->project->getEndDate() < $currentTimestamp) {
            $this->projectActive = false;
        }
        $this->projectActionMode = $request->get('action');

        $this->fillInTabDefinition();
        $this->translateTabDefinition();

        return true;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function projectsListAction(Request $request)
    {
        return $this->render('default/projectsAndTeamsList.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function projectsAction(Request $request)
    {

        if ( $request->get('action') === 'add' ) {
            $this->project = new Projects();
        }
        elseif ( $this->fillProjectInfos($request) === false ) {
            throw $this->createNotFoundException('A problem occured initiating the project object.');
        }

        if ( $request->get('action') != 'view' ) {
            $form = $this->createForm(
                ProjectsFormType::class,
                $this->project
            );

            $form->handleRequest($request);

            $this->project = $form->getData();

            if ( $form->isSubmitted() && $form->isValid() ) {
                try {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($this->project);
                    $em->flush();

                    return $this->redirectToRoute(
                        'projects',
                        array(
                            'id' => $this->project->getId(),
                            'action' => 'view',
                            '_locale' => $request->getLocale()
                        )
                    );
                }
                catch (\Exception $e) {
                    $translator = $this->get('translator');
                    $message = $e->getMessage();
                    if (strpos($message, 'SQLSTATE[23505]') !== false) {
                        $message = $translator->trans('app.errors.insert.uniqueViolation', array(), 'messages');
                    }
                    $this->addFlash('error', $message);
                }
            }

            if ( $request->get('action') === 'add' ) {
                return $this->render(
                    'default/teamsProjectsNew.html.twig',
                    array(
                        'form' => $form->createView(),
                    )
                );
            }
            else {
                $this->tabDefinition['tabs']['main']['form'] = $form->createView();
            }
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
    public function renderProjectViewAction(Request $request) {
        if ( $this->fillProjectInfos($request) === false ) {
            throw $this->createNotFoundException('A problem occured initating the project object.');
        }

        $this->tabDefinition['action'] = 'view';

        return $this->render(
            '_partials/tabbedContent/mainTab/view/projects.html.twig',
            $this->tabDefinition
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderProjectEditAction(Request $request) {
        if ( $this->fillProjectInfos($request) === false ) {
            throw $this->createNotFoundException('A problem occured initating the project object.');
        }

        $this->tabDefinition['action'] = 'edit';
        $this->tabDefinition['tabs']['main']['form'] = $request->get('form', null);

        return $this->render(
            '_partials/tabbedContent/mainTab/edit/projects.html.twig',
            $this->tabDefinition
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderRelatedProjectsViewContainerAction(Request $request) {
        return $this->render(
            '_partials/tabbedContent/relatedTabs/view/projects.html.twig',
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
    public function renderRelatedProjectsViewAction(Request $request) {
        if( $request->get('type') != 'teams' && $request->get('type') != 'person' ) {
            throw $this->createNotFoundException('You cannot ask for related projects to something else than a team or a person');
        }

        $related_projects = array();
        ($request->get('type')=='teams')?$type='TeamsProjects':$type='ProjectsMembers';

        if ( $request->get('id', 0) !== 0 ) {
            if ($request->get('type') === 'teams') {
                $related_projects = $this->getDoctrine()
                    ->getRepository('AppBundle:TeamsProjects')
                    ->listProjects($request->get('id'), $request->getLocale());
            }
            else {
                $related_projects = $this->getDoctrine()
                    ->getRepository('AppBundle:ProjectsMembers')
                    ->listProjects($request->get('id'),$request->getLocale());
            }
        }

        return $this->render(
            '_partials/tabbedContent/relatedTabs/view/related_projects.html.twig',
            array( 'related_projects' => $related_projects, 'type' => $type )
        );
    }
}
