<?php
/**
 * Created by PhpStorm.
 * User: duchesne
 * Date: 15/09/16
 * Time: 16:06
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class FastSearchController extends Controller
{
    /**
     * @var Request Complete request object
     * @return JsonResponse A Response instance of the form of a json
     */
    public function fastSearchAction(Request $request) {
        if ( !$request->isXmlHttpRequest() ) {
            throw $this->createNotFoundException('You\'re not authorized to execute a fastSearch aside the interface.');
        }

        $results = array();
        $response = new JsonResponse();

        $results = $this->getDoctrine()
            ->getRepository(ucfirst($request->get('fast_search_type')))
            ->searchInName(
                $request->get('term'),
                $request->get('exact', false)
            );

        $response->setData($results);
        return $response;
    }
}
