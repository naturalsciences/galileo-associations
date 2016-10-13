<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Projects as Projects;
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
        'tabs' => array(
            'main' => array(
                'id' => 'projects-tab',
                'collapseElementId' => 'projectsContent',
                'collapseElementDefaultState' => 'in',
                'headingText' => 'app.action.tab.main',
                'headingIcon' => 'fa-cog',
                'item' => null,
                'template_path' => '_partials/tabbedContent/mainTab/view/projects.html.twig'
            ),
            'related-people' => array(
                'id' => 'person-tab',
                'collapseElementId' => 'personContent',
                'collapseElementDefaultState' => '',
                'headingText' => 'app.action.tab.relatedPeople',
                'headingIcon' => 'fa-user',
                'item' => null,
                'template_path' => '_partials/tabbedContent/relatedTabs/view/person.html.twig'
            ),
            'related-teams' => array(
                'id' => 'teams-tab',
                'collapseElementId' => 'teamsContent',
                'collapseElementDefaultState' => '',
                'headingText' => 'app.action.tab.relatedTeams',
                'headingIcon' => 'fa-users',
                'item' => null,
                'template_path' => '_partials/tabbedContent/relatedTabs/view/teams.html.twig'
            )
        )
    );

    /**
     * @return array Return the tab definition array with the necessary parts translated
     */
    private function translateTabDefinition() {

        $this->tabDefinition['name_label'] = $this
            ->get('translator')
            ->trans(
                $this->tabDefinition['name_label'],
                array(),
                "messages"
            );
        $this->tabDefinition['tabs']['main']['headingText'] = $this
            ->get('translator')
            ->trans(
                $this->tabDefinition['tabs']['main']['headingText'],
                array(),
                "messages"
            );
        $this->tabDefinition['tabs']['related-teams']['headingText'] = $this
            ->get('translator')
            ->trans(
                $this->tabDefinition['tabs']['related-teams']['headingText'],
                array(),
                "messages"
            );
        $this->tabDefinition['tabs']['related-people']['headingText'] = $this
            ->get('translator')
            ->trans(
                $this->tabDefinition['tabs']['related-people']['headingText'],
                array(),
                "messages"
            );

        return $this->tabDefinition;
    }

    /**
     * @param Projects $project Project Entity Object
     * @param bool $isActive Pass the boolean that tells if project active or not
     */
    private function fillInTabDefinition(Projects $project, $isActive) {
        $this->tabDefinition['name']=trim($project->getInternationalName());
        $this->tabDefinition['id']=$project->getId();
        $this->tabDefinition['active']=$isActive;
        $this->tabDefinition['tabs']['main']['item']=$project;

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
            $this->fillInTabDefinition($project, $isActive);
            $this->translateTabDefinition();
            return $this->render(
                'default/tabbedContent.html.twig',
                $this->tabDefinition
            );
        }

        return $this->render('');
    }
}
