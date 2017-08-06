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
            $this->addFlash(
                'error',
                'You must enter a valid number'
            );
            return $this->redirectToRoute('homepage');
        }

        $acmeCommunicationsManager = $this->container->get('AppBundle\Model\CommunicationsManager');

        try {
            $summary = $acmeCommunicationsManager->getInfo($number);
        } catch (InvalidNumberFormat $e) {
            $this->addFlash('error', 'The number has an invalid format');
            return $this->redirectToRoute('homepage');
        } catch (CommunicationsException $e) {
            $this->addFlash('error', $e->getMessage());
            return $this->redirectToRoute('homepage');
        }

        return $this->render('default/list.html.twig', [
            'contacts' => $summary->getCommunicationsGroupedByContact(),
            'number'   => $number
        ]);
    }
}
