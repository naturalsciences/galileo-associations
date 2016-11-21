<?php

namespace AppBundle\Controller\Rest;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class PeopleController extends Controller
{
    /**
     * @return JsonResponse $response The complete (first 1000) list of people
     */
    public function listAction()
    {
        $data['people'] = $this->getDoctrine()
            ->getRepository('AppBundle:Person')
            ->listAll();
        $response = new JsonResponse($data);
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        return $response;
    }
}
