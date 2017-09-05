<?php

namespace SBC\GrifoflexFrontBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class GrifoflexTunisiaController
 * @package SBC\GrifoflexFrontBundle\Controller
 * @Route("{_locale}", requirements={"_locale": "fr|en"})
 */
class GrifoflexTunisiaController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/grifoflex-tunisia", name="gfftunisia")
     * @Method({"GET","POST"})
     */
    public function gfftunisiaAction()
    {

        return $this->render('@Grifoflex/gfftunisia/index.html.twig');
    }
}
