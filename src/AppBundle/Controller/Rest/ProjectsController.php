<?php

namespace AppBundle\Controller\Rest;

use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProjectsController extends BaseController
{
    /**
     * @return JsonResponse $response The complete (first 3000) list of projects
     */
    public function listAction()
    {
        $data['projects'] = $this->getDoctrine()
            ->getRepository('AppBundle:Projects')
            ->listAll();
        return $this->handleJsonResponse($data, 'projects');
    }

    /**
     * @param Request $request
     * @return JsonResponse $response The filtered list of projects - filtering based on the list of Ids
     */
    public function listByIdAction(Request $request) {
        $ids = explode(',', $request->get('id'));
        $relatedFilters = array();
        $data['projets'] = $this->getDoctrine()
            ->getRepository('AppBundle:Projects')
            ->listByIds($ids, $relatedFilters);
        return $this->handleJsonResponse($data, 'projects');
    }

    /**
     * @param Request $request
     * @return JsonResponse $response The filtered list of projects - filtering based on the list of Ids
     */
    public function listByNameAction(Request $request) {
        $names = explode(',', $request->get('name'));
        $relatedFilters = array();
        $data['projects'] = $this->getDoctrine()
            ->getRepository('AppBundle:Projects')
            ->listByIntNames($names, $relatedFilters);
        return $this->handleJsonResponse($data, 'projects');
    }
}
