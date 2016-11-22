<?php

namespace AppBundle\Controller\Rest;

use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PeopleController extends BaseController
{
    /**
     * @return JsonResponse $response The complete (first 3000) list of people
     */
    public function listAction()
    {
        $data['people'] = $this->getDoctrine()
            ->getRepository('AppBundle:Person')
            ->listAll();
        return $this->handleJsonResponse($data, 'people');
    }

    /**
     * @param Request $request
     * @return JsonResponse $response The filtered list of people - filtering based on the list of Ids
     */
    public function listByIdAction(Request $request) {
        $ids = explode(',', $request->get('id'));
        $relatedFilters = array();
        $data['people'] = $this->getDoctrine()
            ->getRepository('AppBundle:Person')
            ->listByIds($ids, $relatedFilters);
        return $this->handleJsonResponse($data, 'people');
    }

    /**
     * @param Request $request
     * @return JsonResponse $response The filtered list of people - filtering based on the list of Ids
     */
    public function listByNameAction(Request $request) {
        $names = explode(',', $request->get('name'));
        $relatedFilters = array();
        $data['people'] = $this->getDoctrine()
            ->getRepository('AppBundle:Person')
            ->listByNames($names, $relatedFilters);
        return $this->handleJsonResponse($data, 'people');
    }
}
