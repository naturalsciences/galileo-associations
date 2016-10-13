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
        'name_label' => 'app.meta.title.tab.project',
        'name' => '',
        'id' => null,
        'active' => true,
        'tabs' => array(
            'main' => array(
                'id' => 'teams-tab',
                'collapseElementId' => 'teamsContent',
                'collapseElementDefaultState' => 'in',
                'headingText' => 'app.action.tab.main',
                'headingIcon' => 'fa-cog',
                'item' => null,
                'template_path' => '_partials/tabbedContent/mainTab/view/teams.html.twig'
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
            'related-projects' => array(
                'id' => 'projects-tab',
                'collapseElementId' => 'projectsContent',
                'collapseElementDefaultState' => '',
                'headingText' => 'app.action.tab.relatedProjects',
                'headingIcon' => 'fa-suitcase',
                'item' => null,
                'template_path' => '_partials/tabbedContent/relatedTabs/view/projects.html.twig'
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
        $this->tabDefinition['tabs']['related-projects']['headingText'] = $this
            ->get('translator')
            ->trans(
                $this->tabDefinition['tabs']['related-projects']['headingText'],
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
     * @param Teams $team Team Entity Object
     * @param bool $isActive Pass the boolean that tells if team active or not
     */
    private function fillInTabDefinition(Teams $team, $isActive) {
        $this->tabDefinition['name']=trim($team->getInternationalName());
        $this->tabDefinition['id']=$team->getId();
        $this->tabDefinition['active']=$isActive;
        $this->tabDefinition['tabs']['main']['item']=$team;

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
        $isActive = true;
        if ($request->get('action') === 'add') {
            $team = new Teams();
        } else {
            $team = $this->findTeam($request->get('id'));
            if ($team === null) {
                throw $this->createNotFoundException('The person does not exists.');
            }
            $currentTimestamp = new \DateTime();
            if ( $team->getEndDate() !== null && $team->getEndDate() < $currentTimestamp) {
                $isActive = false;
            }
        }

        if ($request->get('action') === 'view') {
            $this->fillInTabDefinition($team, $isActive);
            $this->translateTabDefinition();
            return $this->render(
                'default/tabbedContent.html.twig',
                $this->tabDefinition
            );
        }

        return $this->render('');
    }
}
