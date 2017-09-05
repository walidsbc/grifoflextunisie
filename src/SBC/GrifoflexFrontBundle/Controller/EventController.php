<?php

namespace SBC\GrifoflexFrontBundle\Controller;


use SBC\GrifoflexTunisieBundle\Entity\Event;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Class EventController
 * @package SBC\GrifoflexFrontBundle\Controller
 * @Route("/", requirements={"_locale": "fr|en"})
 */
class EventController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("{_locale}/events", name="event_events", options = { "expose" = true })
     * @Method({"GET","POST"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('GrifoflexTunisieBundle:Event')->findAll();

        return $this->render('@Grifoflex/event/events.html.twig', array(
            'events' => $events
        ));
    }



    /**
     * @param Event $event
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("{_locale}/event/{id}", name="event_view")
     * @Method({"GET","POST"})
     */
    public function showAction(Event $event)
    {

        return $this->render('@Grifoflex/event/event.html.twig', array(
            'event' => $event
        ));
    }



}
