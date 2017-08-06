<?php

namespace AppBundle\Controller;

use AppBundle\Model\Exception\CommunicationsException;
use AppBundle\Model\Exception\InvalidNumberFormat;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/list", name="listpage")
     */
    public function listAction(Request $request)
    {
        $number = $request->request->get('phone');

        if ($number == null) {
            return new Response('Invalid number');
        }

        $acmeCommunicationsManager = $this->container->get('AppBundle\Model\CommunicationsManager');

        try {
            $summary = $acmeCommunicationsManager->getInfo($number);
        } catch (InvalidNumberFormat $e) {
            return new Response("The number has an invalid format");
        } catch (CommunicationsException $e) {
            return new Response("Sorry, there was a problem retrieving your info. Try it later");
        }

        return $this->render('default/list.html.twig', [
            'contacts' => $summary->getCommunicationsGroupedByContact(),
            'number'   => $number
        ]);
    }
}
