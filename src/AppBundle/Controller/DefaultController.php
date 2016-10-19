<?php

namespace AppBundle\Controller;

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
     * @param Request $request The request passed composed of a type and of an id
     * @return JsonResponse $response A Json containing the result of delete tentative
     */
    public function removeAction(Request $request)
    {
        $type = $request->get('type', '');
        $translator = $this->get('translator');
        $response = new JsonResponse();

        if (
            !$request->isXmlHttpRequest() ||
            (
                $type != 'teams' &&
                $type != 'projects' &&
                $type != 'TeamsMembers' &&
                $type != 'ProjectsMembers' &&
                $type != 'TeamsProjects'
            )
        ) {
            $this->addFlash('error', $translator->trans('app.message.remove.failure.403', array(), 'messages'));
            $this->createAccessDeniedException('You cannot access this action aside from the application');
        }

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
}
