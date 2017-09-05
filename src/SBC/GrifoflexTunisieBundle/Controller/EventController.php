<?php

namespace SBC\GrifoflexTunisieBundle\Controller;

use SBC\GrifoflexTunisieBundle\Entity\Event;
use SBC\GrifoflexTunisieBundle\Form\EventType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EventController
 * @package SBC\GrifoflexTunisieBundle\Controller
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class EventController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Route("back-office/events/", name="event_index", options = { "expose" = true })
     * @Method({"GET","POST"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('GrifoflexTunisieBundle:Event')->findAll();

        return $this->render('@GrifoflexTunisie/event/index.html.twig', array(
            'events' => $events
        ));
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("back-office/event/new", name="event_new")
     * @Method({"GET","POST"})
     */
    public function newAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('event_show', array('id' => $event->getId()));
        }

        return $this->render('@GrifoflexTunisie/event/new.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Event $event
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("back-office/event/{id}", name="event_show")
     * @Method({"GET","POST"})
     */
    public function showAction(Event $event)
    {

        return $this->render('@GrifoflexTunisie/event/show.html.twig', array(
            'event' => $event
        ));
    }

    /**
     * @param Request $request
     * @param Event $event
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("back-office/event/{id}/edit", name="event_edit")
     * @Method({"GET","POST"})
     */
    public function editAction(Request $request, Event $event)
    {

        $editForm = $this->createForm(EventType::class, $event);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em = $this->getDoctrine()->getManager();
            foreach ($event->getPictures() as $picture) {
                if ($picture->getDescription() == null) {
                    $event->removePicture($picture);
                    $em->remove($picture);
                } else {
                    $event->addPicture($picture);
                }
            }
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('event_show', array('id' => $event->getId()));
        }

        return $this->render('@GrifoflexTunisie/event/edit.html.twig', array(
            'event' => $event,
            'form' => $editForm->createView()
        ));
    }

    /**
     * @param Event $event
     * @return JsonResponse
     * @Route("back-office/event/{id}", name="event_delete", options = { "expose" = true })
     * @Method("DELETE")
     */
    public function deleteAction(Event $event)
    {
        $em = $this->getDoctrine()->getManager();
        $deleted = true;

        try {
            $em->remove($event);
            $em->flush();
        } catch (\Exception $e) {
            $deleted = false;

        }
        return new JsonResponse(array('deleted' => $deleted));
    }

    /**
     * @param $title
     * @return JsonResponse
     * @Route("back-office/event/{title}/check_unique", name="event_check_unique", options = { "expose" = true })
     * @Method({"GET","POST"})
     */
    public function findByTitleAction($title)
    {
        $event = $this->getDoctrine()
            ->getManager()
            ->getRepository('GrifoflexTunisieBundle:Event')
            ->findOneBy(array('title' => $title));

        $exists = true;

        if ($event === null)
            $exists = false;

        return new JsonResponse(array('exists' => $exists));
    }


}
