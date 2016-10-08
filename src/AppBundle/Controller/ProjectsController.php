<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Projects;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProjectsController extends Controller
{

    /**
     * @var array $tabDefinition Defines the default tab structure and feed
     */
    private $tabDefinition = array(
        'type' => 'projects',
        'name_label' => 'Project',
        'name' => '',
        'id' => null,
        'tabs' => array(
            'main' => array(
                'id' => 'projects-tab',
                'collapseElementId' => 'projectsContent',
                'collapseElementDefaultState' => 'in',
                'headingText' => 'Main',
                'headingIcon' => 'fa-cog',
                'items' => null,
                'template_path' => '_partials/tabbedContent/mainTab/view/projects.html.twig'
            ),
            'related-people' => array(
                'id' => 'person-tab',
                'collapseElementId' => 'personContent',
                'collapseElementDefaultState' => '',
                'headingText' => 'Related People',
                'headingIcon' => 'fa-user',
                'items' => null,
                'template_path' => '_partials/tabbedContent/relatedTabs/view/person.html.twig'
            ),
            'related-teams' => array(
                'id' => 'teams-tab',
                'collapseElementId' => 'teamsContent',
                'collapseElementDefaultState' => '',
                'headingText' => 'Related Teams',
                'headingIcon' => 'fa-users',
                'items' => null,
                'template_path' => '_partials/tabbedContent/relatedTabs/view/teams.html.twig'
            )
        )
    );

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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function projectsListAction(Request $request)
    {
        return $this->render('');
    }
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function projectsAction(Request $request)
    {
        if ( $request->get('action') === 'add' ) {
            $project = new Projects();
        }
        else {
            $project = $this->findProject( $request->get('id') );
            if ( $project === null ) {
                throw $this->createNotFoundException('The person does not exists.');
            }
        }

        if ( $request->get('action') === 'view' ) {

            $this->tabDefinition['name']=trim($project->getInternationalName());
            $this->tabDefinition['id']=$project->getId();
            $this->tabDefinition['tabs']['main']['items']=$project;
            $this->tabDefinition['tabs']['related-people']['items']=$project->getProjectsMembers();
            $this->tabDefinition['tabs']['related-teams']['items']=$project->getTeamsProjects();

            return $this->render(
                '/default/tabbedContent.html.twig',
                $this->tabDefinition
            );
        }

        return $this->render('');
    }
}
