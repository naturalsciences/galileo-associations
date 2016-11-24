<?php

namespace AppBundle\Controller\Rest;

use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TeamsController extends BaseController
{
    /**
     * @return JsonResponse $response The complete (first 2000) list of teams
     */
    public function listAction(Request $request)
    {
        $relatedFilters = $this->extractRelatedFilters($request);
        $relatedFilters['ids'] = $this->extractIds($request);
        $relatedFilters['names'] = $this->extractNames($request);
        $relatedFilters['uids'] = $this->extractUids($request);
        $active = $this->extractActive($request);

        $data['teams'] = $this->getDoctrine()
            ->getRepository('AppBundle:Teams')
            ->listAll($active, $relatedFilters);
        return $this->handleJsonResponse($data, 'teams');
    }

    /**
     * @param Request $request
     * @return JsonResponse $response The filtered list of teams - filtering based on the list of Ids
     */
    public function listByIdAction(Request $request) {
        $id = explode(',', $request->get('id'));
        $active = $this->extractActive($request);
        $relatedFilters = $this->extractRelatedFilters($request);

        $data['teams'] = $this->getDoctrine()
            ->getRepository('AppBundle:Teams')
            ->listById($active, $id, $relatedFilters);
        return $this->handleJsonResponse($data, 'teams');
    }

    /**
     * @param Request $request
     * @return JsonResponse $response The filtered list of teams - filtering based on the list of Ids
     */
    public function listByNameAction(Request $request) {
        $name = explode(',', $request->get('name'));
        $active = $this->extractActive($request);
        $relatedFilters = $this->extractRelatedFilters($request);

        $data['teams'] = $this->getDoctrine()
            ->getRepository('AppBundle:Teams')
            ->listByName($active, $name, $relatedFilters);
        return $this->handleJsonResponse($data, 'teams');
    }
}
