<?php

namespace AppBundle\Controller\Rest;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProjectsController extends Controller
{
    /**
     * @return JsonResponse $response The complete (first 1000) list of projects
     */
    public function listAction()
    {
        $data['projects'] = $this->getDoctrine()
            ->getRepository('AppBundle:Projects')
            ->listAll();
        $response = new JsonResponse($data);
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        return $response;
    }
}
