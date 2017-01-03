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
            throw $this->createNotFoundException('No record found !');
        }
        $response->setStatusCode(200);
        return $response;
    }

    /**
     * @param Request $request
     * @return string
     */
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

    /**
     * @param Request $request
     * @return array
     */
    protected function extractIds(Request $request) {
        $ids = array();
        if ( $request->query->get('ids', '') !== '' ) {
            $ids = explode(',', $request->query->get('ids'));
        }
        return $ids;
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function extractNames(Request $request) {
        $names = array();
        if ( $request->query->get('names', '') !== '' ) {
            $names = explode(',', $request->query->get('names'));
        }
        return $names;
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function extractUids(Request $request) {
        $uids = array();
        if ( $request->query->get('samaccountname', '') !== '' ) {
            $uids = explode(',', $request->query->get('samaccountname'));
        }
        return $uids;
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function extractRelatedFilters (Request $request) {
        $relatedFilters = array();
        if ( $request->query->get('teams', '') !== '' ) {
            $relatedFilters['teams'] = explode(',', $request->query->get('teams'));
        }
        if ( $request->query->get('projects', '') !== '' ) {
            $relatedFilters['projects'] = explode(',', $request->query->get('projects'));
        }
        if ( $request->query->get('people', '') !== '' ) {
            $relatedFilters['people'] = explode(',', $request->query->get('people'));
        }
        if ( $request->query->get('directorates', '') !== '' ) {
            $relatedFilters['directorates'] = explode(',', $request->query->get('directorates'));
        }
        if ( $request->query->get('services', '') !== '' ) {
            $relatedFilters['services'] = explode(',', $request->query->get('services'));
        }
        return $relatedFilters;
    }

    /**
     * @param Request $request
     * @return string
     */
    protected function extractWithoutDescription (Request $request) {
        $withoutDescr = 'false';
        $withoutDescrKeyword = $request->query->get('withoutdescription', '');
        if( in_array(
            strtolower($withoutDescrKeyword),
            array('true', '1', 'yes')
        )
        ) {
            $withoutDescr = 'true';
        }
        return $withoutDescr;
    }

}
