<?php

namespace SBC\GrifoflexTunisieBundle\Controller;

use SBC\GrifoflexTunisieBundle\Entity\Application;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class ApplicationController
 * @package SBC\GrifoflexTunisieBundle\Controller
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class ApplicationController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("back-office/applications", name="application_index", options = { "expose" = true })
     * @Method({"GET","POST"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $applications = $em->getRepository('GrifoflexTunisieBundle:Application')->findAll();

        return $this->render('@GrifoflexTunisie/application/index.html.twig', array(
            'applications' => $applications,
        ));
    }


    /**
     * @param Application $application
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("back-office/application/{id}", name="application_show")
     * @Method({"GET","POST"})
     */
    public function showAction(Application $application)
    {
        return $this->render('@GrifoflexTunisie/application/show.html.twig', array(
            'application' => $application
        ));
    }

}
