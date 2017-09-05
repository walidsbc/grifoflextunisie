<?php

namespace SBC\GrifoflexFrontBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class HomeController
 * @package SBC\GrifoflexFrontBundle\Controller
 * @Route("{_locale}", requirements={"_locale": "fr|en"})
 */
class HomeController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="home")
     * @Method({"GET","POST"})
     */
    public function homeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $sliders = $em->getRepository('GrifoflexTunisieBundle:Slider')->findAll();

        return $this->render('@Grifoflex/home/home.html.twig', array(
            'sliders' => $sliders
        ));
    }
}
