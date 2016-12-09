<?php

namespace AppBundle\Controller\Rest;

use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DepartmentsController extends BaseController
{

    /**
     * @return JsonResponse $response The complete (first 3000) list of departments
     */
    public function listAllAction(Request $request)
    {
        $relatedFilters = $this->extractRelatedFilters($request);
        $relatedFilters['ids'] = $this->extractIds($request);
        $relatedFilters['names'] = $this->extractNames($request);
        $active = $this->extractActive($request);

        $data['departments'] = $this->getDoctrine()
            ->getRepository('AppBundle:Department')
            ->listAll($active, $relatedFilters);
        return $this->handleJsonResponse($data, 'departments');
    }

    /**
     * @return JsonResponse $response The complete (first 3000) list of directorates
     */
    public function listDirectoratesAction(Request $request)
    {
        $relatedFilters = $this->extractRelatedFilters($request);
        $relatedFilters['ids'] = $this->extractIds($request);
        $relatedFilters['names'] = $this->extractNames($request);
        $active = $this->extractActive($request);

        $data['directorates'] = $this->getDoctrine()
            ->getRepository('AppBundle:Department')
            ->listAllDirectorates($active, $relatedFilters);
        return $this->handleJsonResponse($data, 'directorates');
    }

    /**
     * @return JsonResponse $response The complete (first 3000) list of services
     */
    public function listServicesAction(Request $request)
    {
        $relatedFilters = $this->extractRelatedFilters($request);
        $relatedFilters['ids'] = $this->extractIds($request);
        $relatedFilters['names'] = $this->extractNames($request);
        $active = $this->extractActive($request);

        $data['services'] = $this->getDoctrine()
            ->getRepository('AppBundle:Department')
            ->listAllServices($active, $relatedFilters);
        return $this->handleJsonResponse($data, 'services');
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
            ->getRepository('AppBundle:Department')
            ->listById($active, $id, $relatedFilters);
        return $this->handleJsonResponse($data, 'directorates');
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
            ->getRepository('AppBundle:Department')
            ->listByName($active, $name, $relatedFilters);
        return $this->handleJsonResponse($data, 'directorates');
    }
}
