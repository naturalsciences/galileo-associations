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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class FastSearchController extends Controller
{
    /**
     * @var Request Complete request object
     * @return JsonResponse A Response instance of the form of a json
     */
    public function fastSearchAction(Request $request) {
        $results = array();
        $response = new JsonResponse();
        if (
            $request->isXmlHttpRequest() &&
            $request->get('fast_search_type') !== null
        ){
        }
        $response->setData($results);
        return $response;
    }
}
