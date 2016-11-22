<?php

namespace AppBundle\Controller\Rest;

use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TeamsController extends BaseController
{
    /**
     * @return JsonResponse $response The complete (first 3000) list of teams
     */
    public function listAction()
    {
        $data['teams'] = $this->getDoctrine()
            ->getRepository('AppBundle:Teams')
            ->listAll();
        return $this->handleJsonResponse($data, 'teams');
    }

    /**
     * @param Request $request
     * @return JsonResponse $response The filtered list of teams - filtering based on the list of Ids
     */
    public function listByIdAction(Request $request) {
        $ids = explode(',', $request->get('id'));
        $relatedFilters = array();
        $data['teams'] = $this->getDoctrine()
            ->getRepository('AppBundle:Teams')
            ->listByIds($ids, $relatedFilters);
        return $this->handleJsonResponse($data, 'teams');
    }

    /**
     * @param Request $request
     * @return JsonResponse $response The filtered list of teams - filtering based on the list of Ids
     */
    public function listByNameAction(Request $request) {
        $names = explode(',', $request->get('name'));
        $relatedFilters = array();
        $data['teams'] = $this->getDoctrine()
            ->getRepository('AppBundle:Teams')
            ->listByIntNames($names, $relatedFilters);
        return $this->handleJsonResponse($data, 'teams');
    }
}
