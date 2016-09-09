<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

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
     * @var Request Complete request object
     * @return JsonResponse A Response instance of the form of a json
     */
    public function fastSearchAction(Request $request) {
        $results = array();
        $response = new JsonResponse();
        if (
            $request->isXmlHttpRequest() &&
            $request->get('fast_search_type') !== null
        ){
        }
        $response->setData($results);
        return $response;
    }
}
