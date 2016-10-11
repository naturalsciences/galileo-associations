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
        'active' => true,
        'tabs' => array(
            'main' => array(
                'id' => 'teams-tab',
                'collapseElementId' => 'teamsContent',
                'collapseElementDefaultState' => 'in',
                'headingText' => 'Main',
                'headingIcon' => 'fa-cog',
                'item' => null,
                'template_path' => '_partials/tabbedContent/mainTab/view/teams.html.twig'
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

            $this->tabDefinition['name']=trim($team->getInternationalName());
            $this->tabDefinition['id']=$team->getId();
            $this->tabDefinition['active']=$isActive;
            $this->tabDefinition['tabs']['main']['item']=$team;

            return $this->render(
                'default/tabbedContent.html.twig',
                $this->tabDefinition
            );
        }

        return $this->render('');
    }
}
