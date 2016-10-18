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
            throw $this->createNotFoundException('You\'re not authorized to execute a remove aside the interface.');
        }

        $response = new JsonResponse();
        $response->setData(array('response' => 'ok'));

        $em = $this->getDoctrine()->getManager();

        $results = $em->find('AppBundle:'.ucfirst($type), $request->get('id'));

        if (  !$results ) {
            $response->setData(array('response' => 'No entity found'));
            $response->setStatusCode(419);
        }

        try {
            $em->remove($results);
            $em->flush();
        }
        catch (\Exception $e) {
            $response->setData(array('response'=>$e->getMessage()));
            $response->setStatusCode(419);
        }

        return $response;
    }
}
