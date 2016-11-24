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
    public function listAction(Request $request)
    {
        $relatedFilters = $this->extractRelatedFilters($request);
        $relatedFilters['ids'] = $this->extractIds($request);
        $relatedFilters['names'] = $this->extractNames($request);
        $relatedFilters['uids'] = $this->extractUids($request);
        $active = $this->extractActive($request);

        $data['people'] = $this->getDoctrine()
            ->getRepository('AppBundle:Person')
            ->listAll($active, $relatedFilters);
        return $this->handleJsonResponse($data, 'people');
    }

    /**
     * @param Request $request
     * @return JsonResponse $response The filtered list of people - filtering based on the list of Ids
     */
    public function listByIdAction(Request $request) {
        $id = explode(',', $request->get('id'));
        $active = $this->extractActive($request);
        $relatedFilters = $this->extractRelatedFilters($request);

        $data['people'] = $this->getDoctrine()
            ->getRepository('AppBundle:Person')
            ->listById($active, $id, $relatedFilters);
        return $this->handleJsonResponse($data, 'people');
    }

    /**
     * @param Request $request
     * @return JsonResponse $response The filtered list of people - filtering based on the list of Ids
     */
    public function listByNameAction(Request $request) {
        $name = explode(',', $request->get('name'));
        $active = $this->extractActive($request);
        $relatedFilters = $this->extractRelatedFilters($request);

        $data['people'] = $this->getDoctrine()
            ->getRepository('AppBundle:Person')
            ->listByName($active, $name, $relatedFilters);
        return $this->handleJsonResponse($data, 'people');
    }
}
