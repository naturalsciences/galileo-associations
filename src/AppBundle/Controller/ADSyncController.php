<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ADSyncController extends Controller
{
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('default/adsync.html.twig');
    }

    /**
     * @return Response
     */
    public function refreshAction(Request $request) {
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
