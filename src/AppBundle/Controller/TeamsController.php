<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Teams;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TeamsController extends Controller
{
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
            return $this->render(
                '/default/tabbedContent.html.twig',
                array(
                    'type' => 'teams',
                    'name_label' => 'Team',
                    'name' => trim($team->getInternationalName()),
                    'tabs' => array(
                        'main' => array(
                            'id' => 'teams-tab',
                            'collapseElementId' => 'teamsContent',
                            'collapseElementDefaultState' => 'in',
                            'headingText' => 'Main',
                            'headingIcon' => 'fa-cog',
                            'items' => $team,
                            'template_path' => '_partials/tabbedContent/mainTab/view/teams.html.twig'
                        ),
                        'related-people' => array(
                            'id' => 'person-tab',
                            'collapseElementId' => 'personContent',
                            'collapseElementDefaultState' => '',
                            'headingText' => 'Related People',
                            'headingIcon' => 'fa-user',
                            'items' => $team->getTeamsMembers(),
                            'template_path' => '_partials/tabbedContent/relatedTabs/view/person.html.twig'
                        ),
                        'related-projects' => array(
                            'id' => 'projects-tab',
                            'collapseElementId' => 'projectsContent',
                            'collapseElementDefaultState' => '',
                            'headingText' => 'Related Projects',
                            'headingIcon' => 'fa-suitcase',
                            'items' => $team->getTeamsProjects(),
                            'template_path' => '_partials/tabbedContent/relatedTabs/view/projects.html.twig'
                        )
                    )
                )
            );
        }

        return $this->render('');
    }
}
