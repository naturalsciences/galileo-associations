<?php

namespace AppBundle\Controller\Rest;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class TeamsController extends Controller
{
    /**
     * @return JsonResponse $response The complete (first 1000) list of teams
     */
    public function listAction()
    {
        $data['teams'] = $this->getDoctrine()
            ->getRepository('AppBundle:Teams')
            ->listAll();
        $response = new JsonResponse($data);
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        return $response;
    }
}
