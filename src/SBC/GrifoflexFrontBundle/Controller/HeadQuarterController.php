<?php

namespace SBC\GrifoflexFrontBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class HeadQuarterController
 * @package SBC\GrifoflexFrontBundle\Controller
 * @Route("{_locale}", requirements={"_locale": "fr|en"})
 */
class HeadQuarterController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/headquarter", name="headquarter")
     * @Method({"GET","POST"})
     */
    public function headquarterAction()
    {

        return $this->render('@Grifoflex/headquarter/index.html.twig');
    }
}
