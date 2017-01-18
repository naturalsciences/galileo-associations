<?php

namespace AppBundle\Controller;

use AppBundle\Utils\Util;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;

class ADSyncController extends Controller
{
    /**
     * @var string Parameter passed to activate the filtering over the corresponding entries in ADSync for People retrieval
     */
    private $uidState = 'all';

    /**
     * ADSyncController responsible of returning the translated activeOptions.
     */
    private function translateActiveOptions(){
        $translator = $this->get('translator');
        $utils = new Util();
        $activeOptions = $utils->getActiveOptions();
        foreach ( $activeOptions as &$value ) {
            $value = $translator->trans($value,array(), 'content-db');
        }
        return $activeOptions;
    }

    /**
     * @param string $content content returned by a command call
     */
    private function setFlashFromRefreshContent($content) {
        $translator = $this->get('translator');
        if ( substr($content, 0, 2) === 'OK' ) {
            $this->addFlash(
                'success',
                $translator->trans('app.flash.adsync.success')
            );
        }
        else {
            $this->addFlash(
                'danger',
                $translator->trans('app.flash.adsync.failure')
            );
        }
    }

    /**
     * @return array List of different tabs to display
     */
    private function extractTabsContent(){
        $translator = $this->get('translator');
        $path = $this->get('kernel')->locateResource("@AppBundle/Resources/config/templating/tabs.tpl.yml");
        $tabsConfig = Yaml::parse(file_get_contents($path));
        $tabs = array();
        if ( isset( $tabsConfig['adsync']['tabs'] ) && count( $tabsConfig['adsync']['tabs'] ) > 0 ) {
            $tabs = $tabsConfig['adsync']['tabs'];
        }
        foreach ( $tabs as &$tab ){
            if ( isset($tab['headingText']) && $tab['headingText'] !== '' ){
                $tab['headingText'] = $translator->trans($tab['headingText']);
            }
        }
        return $tabs;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $activeOptions = $this->translateActiveOptions();
        $tabs = $this->extractTabsContent();
        $people = $this->getDoctrine()
            ->getRepository('AppBundle:Person')
            ->groupsByLetters($request->get('letter', '*'), $request->get('active', 'active'), 0, $this->uidState);
        if ($request->isXmlHttpRequest()) {
            $JsonResponse = array();
            foreach($people as $key=>$person) {
                $JsonResponse[$key]['letterNav'] = $this->renderView('_partials/listContent/letterNav.html.twig', array('type'=>$key, 'groupsLetter'=>$person));
                $JsonResponse[$key]['letterDetails'] = $this->renderView('_partials/listContent/letterADDetails.html.twig', array('type'=>$key, 'groupsLetter'=>$person));
            }

            return new JsonResponse(
                $JsonResponse
            );
        }

        return $this->render(
            'default/adsync.html.twig',
            array(
                'activeOptions' => $activeOptions,
                'tabs' => $tabs,
                'people' => $people,
            )
        );
    }

    /**
     * @return Response
     */
    public function refreshAction() {
        // Bootstrap a new Application to call the Command
        $kernel = $this->get('kernel');
        $application = new Application($kernel);
        $application->setAutoExit(false);

        // Define the command to call
        $input = new ArrayInput(
            array(
                'command' => 'rbins:ad:import',
                '--simple-message' => null
            )
        );

        $output = new BufferedOutput();
        $application->run($input, $output);

        $content = $output->fetch();
        $this->setFlashFromRefreshContent($content);

        // Sends back the flash message partial filled in
        return $this->render(
            '_partials/messages/_messages.html.twig'
        );
    }
}
