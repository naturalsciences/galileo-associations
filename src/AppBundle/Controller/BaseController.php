<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class BaseController extends Controller
{
    /**
     * @param array $data The data passed to be jsonified
     * @param string $key Qualifier/Key of $data array to be used
     * @return JsonResponse $response The JSON response constructed
     */
    protected function handleJsonResponse(Array $data, $key) {
        $response = new JsonResponse($data);
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        if (count($data[$key]) === 0) {
            throw $this->createNotFoundException('No people found !');
        }
        $response->setStatusCode(200);
        return $response;
    }

}
