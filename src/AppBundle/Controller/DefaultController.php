<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ProjectsMembers;
use AppBundle\Entity\TeamsMembers;
use AppBundle\Entity\TeamsProjects;
use AppBundle\Form\Type\ProjectsMembersFormType;
use AppBundle\Form\Type\TeamsMembersFormType;
use AppBundle\Form\Type\TeamsProjectsFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @var Request Complete request object
     * @return Response A Response instance of the form of a twig template filled in
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function editAction(Request $request)
    {
        $type = $request->get('type', '');
        $translator = $this->get('translator');
        $em = $this->getDoctrine()->getManager();
        $results = $em->find('AppBundle:'.ucfirst($type), $request->get('id'));
        $form = null;

        if (  !$results ) {
            $this->addFlash('error', $translator->trans('app.message.remove.failure.404', array(), 'messages'));
            throw $this->createNotFoundException('The record you try to edit seems to not exists anymore. Please check again.');
        }

        switch ( $type ) {
            case "ProjectsMembers":
                $form = $this->createForm(
                    ProjectsMembersFormType::class,
                    $results,
                    array('row_id' => $request->get('id'))
                );
                break;
            case "TeamsMembers":
                $form = $this->createForm(
                    TeamsMembersFormType::class,
                    $results,
                    array('row_id' => $request->get('id'))
                );
                break;
            case "TeamsProjects":
                $form = $this->createForm(
                    TeamsProjectsFormType::class,
                    $results,
                    array('row_id' => $request->get('id'))
                );
                break;
            default:
                $this->addFlash('error', $translator->trans('app.message.remove.failure.404', array(), 'messages'));
                throw $this->createNotFoundException('The record you try to edit seems to not exists anymore. Please check again.');
        }

        if ( $request->getMethod() === 'POST') {
            $form->handleRequest($request);

            $results = $form->getData();

            if ($form->isSubmitted() && $form->isValid()) {
                try {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($results);
                    $em->flush();

                } catch (\Exception $e) {
                    $translator = $this->get('translator');
                    $message = $e->getMessage();
                    if (strpos($message, 'SQLSTATE[23505]') !== false) {
                        $message = $translator->trans('app.errors.insert.uniqueViolation', array(), 'messages');
                    }
                    $this->addFlash('error', $message);
                }
            }
        }

        return $this->render(
            '_partials/tabbedContent/relatedTabs/edit/inlineDatesForm.html.twig',
            array(
                'form' => $form->createView(),
            )
        );

    }

    /**
     * @param Request $request The request passed composed of a type and of an id
     * @return JsonResponse $response A Json containing the result of delete tentative
     */
    public function removeAction(Request $request)
    {
        $type = $request->get('type', '');
        $translator = $this->get('translator');
        $response = new JsonResponse();

        $nameInt = '';
        $route = 'app_homepage';

        $em = $this->getDoctrine()->getManager();
        $results = $em->find('AppBundle:'.ucfirst($type), $request->get('id'));

        if (  !$results ) {
            $this->addFlash('error', $translator->trans('app.message.remove.failure.404', array(), 'messages'));
            throw $this->createNotFoundException('The record you try to remove seems to have already been deleted. Please check again.');
        }

        if ( $type === 'teams' || $type === 'projects' ) {
            $nameInt = $results->getInternationalName();
            $route = $type."_list";
        }

        try {
            $em->remove($results);
            $em->flush();
            $response->setData(array('response' => 'ok', 'route' => $route));
            if ( $type === 'teams' || $type === 'projects' ) {
                $messageVar = $translator->trans($type,array('%name%'=>$nameInt),'content-db');
                $this->addFlash('notice', $this->get('translator')->trans('app.flash.remove.teamsAndProjects', array('%detail%'=>$messageVar), 'messages'));
            }
        }
        catch (\Exception $e) {
            $response->setData(array('response'=>$e->getMessage()));
            $response->setContent($e->getMessage());
            $response->setStatusCode(419);
        }

        return $response;
    }

    public function addAction(Request $request) {
        $mainType = $request->get('type', '');
        $mainTypeId = $request->get('id', '');
        $relatedType = $request->get('related', '');
        $relatedTypeId = $request->get('related_id', '');
        $translator = $this->get('translator');
        $em = $this->getDoctrine()->getManager();
        $response = new Response();

        try {
            $item = null;
            switch ($mainType) {
                case 'person':
                    $person = $em->getRepository('AppBundle:Person')->find($mainTypeId);
                    switch ($relatedType) {
                        case 'projects':
                            $project = $em->getRepository('AppBundle:Projects')->find($relatedTypeId);
                            $item = new ProjectsMembers();
                            $item->setPerson($person);
                            $item->setProjects($project);
                            break;
                        case 'teams':
                            $team = $em->getRepository('AppBundle:Teams')->find($relatedTypeId);
                            $item = new TeamsMembers();
                            $item->setPerson($person);
                            $item->setTeams($team);
                            break;
                    }
                    break;
                case 'teams':
                    $team = $em->getRepository('AppBundle:Teams')->find($mainTypeId);
                    switch ($relatedType) {
                        case 'person':
                            $person = $em->getRepository('AppBundle:Person')->find($relatedTypeId);
                            $item = new TeamsMembers();
                            $item->setTeams($team);
                            $item->setPerson($person);
                            break;
                        case 'projects':
                            $project = $em->getRepository('AppBundle:Projects')->find($relatedTypeId);
                            $item = new TeamsProjects();
                            $item->setTeams($team);
                            $item->setProjects($project);
                            break;
                    }
                    break;
                case 'projects':
                    $project = $em->getRepository('AppBundle:Projects')->find($mainTypeId);
                    switch ($relatedType) {
                        case 'person':
                            $person = $em->getRepository('AppBundle:Person')->find($relatedTypeId);
                            $item = new ProjectsMembers();
                            $item->setProjects($project);
                            $item->setPerson($person);
                            break;
                        case 'teams':
                            $team = $em->getRepository('AppBundle:Teams')->find($relatedTypeId);
                            $item = new TeamsProjects();
                            $item->setProjects($project);
                            $item->setTeams($team);
                            break;
                    }
                    break;
            }

            if ( !is_null($item) ) {
                $em->persist($item);
                $em->flush();
            }

            $targetAction = '';
            switch ( $relatedType ) {
                case 'person':
                    $targetAction = 'AppBundle:Person:renderRelatedPeopleView';
                    break;
                case 'teams':
                    $targetAction = 'AppBundle:Teams:renderRelatedTeamsView';
                    break;
                case 'projects':
                    $targetAction = 'AppBundle:Projects:renderRelatedProjectsView';
                    break;
            }
            if ( $targetAction !== '' ) {
                $response->setContent(
                    $this->forward(
                        $targetAction,
                        array(),
                        array(
                            'type' => $mainType,
                            'id' => $mainTypeId
                        )
                    )->getContent()
                );
                $response->setStatusCode(200);
            }
        }
        catch (\Exception $e) {
            $response->setContent($e->getMessage());
            $response->setStatusCode(419);
        }

        return $response;

    }
}
