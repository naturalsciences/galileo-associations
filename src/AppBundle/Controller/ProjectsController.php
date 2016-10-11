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
        'active' => true,
        'tabs' => array(
            'main' => array(
                'id' => 'projects-tab',
                'collapseElementId' => 'projectsContent',
                'collapseElementDefaultState' => 'in',
                'headingText' => 'Main',
                'headingIcon' => 'fa-cog',
                'item' => null,
                'template_path' => '_partials/tabbedContent/mainTab/view/projects.html.twig'
            ),
            'related-people' => array(
                'id' => 'person-tab',
                'collapseElementId' => 'personContent',
                'collapseElementDefaultState' => '',
                'headingText' => 'Related People',
                'headingIcon' => 'fa-user',
                'item' => null,
                'template_path' => '_partials/tabbedContent/relatedTabs/view/person.html.twig'
            ),
            'related-teams' => array(
                'id' => 'teams-tab',
                'collapseElementId' => 'teamsContent',
                'collapseElementDefaultState' => '',
                'headingText' => 'Related Teams',
                'headingIcon' => 'fa-users',
                'item' => null,
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
        $isActive = true;
        if ( $request->get('action') === 'add' ) {
            $project = new Projects();
        }
        else {
            $project = $this->findProject( $request->get('id') );
            if ( $project === null ) {
                throw $this->createNotFoundException('The person does not exists.');
            }
            $currentTimestamp = new \DateTime();
            if ( $project->getEndDate() !== null && $project->getEndDate() < $currentTimestamp) {
                $isActive = false;
            }
        }

        if ( $request->get('action') === 'view' ) {

            $this->tabDefinition['name']=trim($project->getInternationalName());
            $this->tabDefinition['id']=$project->getId();
            $this->tabDefinition['active']=$isActive;
            $this->tabDefinition['tabs']['main']['item']=$project;

            return $this->render(
                '/default/tabbedContent.html.twig',
                $this->tabDefinition
            );
        }

        return $this->render('');
    }
}
