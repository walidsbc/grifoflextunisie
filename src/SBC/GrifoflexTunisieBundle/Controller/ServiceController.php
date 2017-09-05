<?php

namespace SBC\GrifoflexTunisieBundle\Controller;

use SBC\GrifoflexTunisieBundle\Entity\Service;
use SBC\GrifoflexTunisieBundle\Form\ServiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ServiceController
 * @package SBC\GrifoflexTunisieBundle\Controller
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class ServiceController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("back-office/services/", name="service_index", options = { "expose" = true })
     * @Method({"GET","POST"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $services = $em->getRepository('GrifoflexTunisieBundle:Service')->findAll();

        return $this->render('@GrifoflexTunisie/service/index.html.twig', array(
            'services' => $services,
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("back-office/service/new", name="service_new")
     * @Method({"GET","POST"})
     */
    public function newAction(Request $request)
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();

            return $this->redirectToRoute('service_show', array('id' => $service->getId()));
        }

        return $this->render('@GrifoflexTunisie/service/new.html.twig', array(
            'service' => $service,
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Service $service
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("back-office/service/{id}", name="service_show")
     * @Method({"GET","POST"})
     */
    public function showAction(Service $service)
    {

        return $this->render('@GrifoflexTunisie/service/show.html.twig', array(
            'service' => $service
        ));
    }

    /**
     * @param Request $request
     * @param Service $service
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("back-office/service/{id}/edit", name="service_edit")
     * @Method({"GET","POST"})
     */
    public function editAction(Request $request, Service $service)
    {
        $editForm = $this->createForm(ServiceType::class, $service);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('service_show', array('id' => $service->getId()));
        }

        return $this->render('@GrifoflexTunisie/service/edit.html.twig', array(
            'service' => $service,
            'form' => $editForm->createView()
        ));
    }

    /**
     * @param Service $service
     * @return JsonResponse
     * @Route("back-office/service/{id}", name="service_delete", options = { "expose" = true })
     * @Method("DELETE")
     */
    public function deleteAction(Service $service)
    {
        $em = $this->getDoctrine()->getManager();
        $deleted = true;

        try {
            $em->remove($service);
            $em->flush();
        } catch (\Exception $e) {
            $deleted = false;

        }
        return new JsonResponse(array('deleted' => $deleted));
    }

    /**
     * @param $title
     * @return JsonResponse
     * @Route("back-office/service/{title}/check_unique", name="service_check_unique", options = { "expose" = true })
     * @Method({"GET","POST"})
     */
    public function findByTitleAction($title)
    {

        $service = $this->getDoctrine()
            ->getManager()
            ->getRepository('GrifoflexTunisieBundle:Service')
            ->findOneBy(array('title' => $title));

        $exists = true;

        if ($service === null)
            $exists = false;

        return new JsonResponse(array('exists' => $exists));
    }


}
