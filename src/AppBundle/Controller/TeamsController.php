<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Teams;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TeamsController extends Controller
{

    /**
     * @var array $tabDefinition Defines the default tab structure and feed
     */
    private $tabDefinition = array(
        'type' => 'teams',
        'name_label' => 'Team',
        'name' => '',
        'id' => null,
        'tabs' => array(
            'main' => array(
                'id' => 'teams-tab',
                'collapseElementId' => 'teamsContent',
                'collapseElementDefaultState' => 'in',
                'headingText' => 'Main',
                'headingIcon' => 'fa-cog',
                'items' => null,
                'template_path' => '_partials/tabbedContent/mainTab/view/teams.html.twig'
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
        if ($request->get('action') === 'add') {
            $team = new Teams();
        } else {
            $team = $this->findTeam($request->get('id'));
            if ($team === null) {
                throw $this->createNotFoundException('The person does not exists.');
            }
        }

        if ($request->get('action') === 'view') {

            $this->tabDefinition['name']=trim($team->getInternationalName());
            $this->tabDefinition['id']=$team->getId();
            $this->tabDefinition['tabs']['main']['items']=$team;
            $this->tabDefinition['tabs']['related-people']['items']=$team->getTeamsMembers();
            $this->tabDefinition['tabs']['related-projects']['items']=$team->getTeamsProjects();

            return $this->render(
                'default/tabbedContent.html.twig',
                $this->tabDefinition
            );
        }

        return $this->render('');
    }
}
