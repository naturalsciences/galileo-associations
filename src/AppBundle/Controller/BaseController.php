<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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

    protected function extractActive (Request $request) {
        $active = 'active';
        $activeKeyword = $request->query->get('active', '');
        if( in_array(
            strtolower($activeKeyword),
            array('false', '0', 'inactive', 'no')
        )
        ) {
            $active = 'inactive';
        }
        elseif (
            in_array(
                $activeKeyword,
                array('all', '-1')
            )
        ) {
            $active = 'all';
        }
        return $active;
    }

    protected function extractRelatedFilters (Request $request) {
        $relatedFilters = array();
        if ( $request->query->get('teams', '') !== '' ) {
            $relatedFilters['teams'] = explode(',', $request->query->get('teams'));
        }
        if ( $request->query->get('projects', '') !== '' ) {
            $relatedFilters['projects'] = explode(',', $request->query->get('projects'));
        }
        return $relatedFilters;
    }
}
