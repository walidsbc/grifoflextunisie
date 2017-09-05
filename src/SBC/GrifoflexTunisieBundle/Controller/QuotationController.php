<?php

namespace SBC\GrifoflexTunisieBundle\Controller;

use SBC\GrifoflexTunisieBundle\Entity\Quotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class QuotationController
 * @package SBC\GrifoflexTunisieBundle\Controller
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class QuotationController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Route("back-office/quotations/", name="quotation_index", options = { "expose" = true })
     * @Method({"GET","POST"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $quotations = $em->getRepository('GrifoflexTunisieBundle:Quotation')->findAll();

        return $this->render('@GrifoflexTunisie/quotation/index.html.twig', array(
            'quotations' => $quotations
        ));
    }


    /**
     * @param Quotation $quotation
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("back-office/quotation/{id}", name="quotation_show")
     * @Method({"GET","POST"})
     */
    public function showAction(Quotation $quotation)
    {

        return $this->render('@Grifoflex/quotation/pdf.html.twig', array(
            'quotation' => $quotation
        ));
    }
}
