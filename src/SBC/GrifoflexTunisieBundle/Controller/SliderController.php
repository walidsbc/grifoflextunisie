<?php

namespace SBC\GrifoflexTunisieBundle\Controller;

use SBC\GrifoflexTunisieBundle\Entity\Slider;
use SBC\GrifoflexTunisieBundle\Form\SliderType;
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
class SliderController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Route("back-office/slider/", name="slider_index", options = { "expose" = true })
     * @Method({"GET","POST"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sliders = $em->getRepository('GrifoflexTunisieBundle:Slider')->findAll();

        return $this->render('@GrifoflexTunisie/slider/index.html.twig', array(
            'sliders' => $sliders
        ));
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("back-office/slider/new", name="slider_new")
     * @Method({"GET","POST"})
     */
    public function newAction(Request $request)
    {
        $slider = new Slider();
        $form = $this->createForm(SliderType::class, $slider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($slider);
            $em->flush();

            return $this->redirectToRoute('slider_show', array('id' => $slider->getId()));
        }

        return $this->render('@GrifoflexTunisie/slider/new.html.twig', array(
            'slider' => $slider,
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Slider $slider
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("back-office/slider/{id}", name="slider_show")
     * @Method({"GET","POST"})
     */
    public function showAction(Slider $slider)
    {

        return $this->render('@GrifoflexTunisie/slider/show.html.twig', array(
            'slider' => $slider
        ));
    }

    /**
     * @param Request $request
     * @param Slider $slider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("back-office/slider/{id}/edit", name="slider_edit")
     * @Method({"GET","POST"})
     */
    public function editAction(Request $request, Slider $slider)
    {

        $editForm = $this->createForm(SliderType::class, $slider);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($slider);
            $em->flush();

            return $this->redirectToRoute('slider_show', array('id' => $slider->getId()));
        }

        return $this->render('@GrifoflexTunisie/slider/edit.html.twig', array(
            'slider' => $slider,
            'form' => $editForm->createView()
        ));
    }

    /**
     * @param Slider $slider
     * @return JsonResponse
     * @Route("back-office/slider/{id}", name="slider_delete", options = { "expose" = true })
     * @Method("DELETE")
     */
    public function deleteAction(Slider $slider)
    {
        $em = $this->getDoctrine()->getManager();
        $deleted = true;

        try {
            $em->remove($slider);
            $em->flush();
        } catch (\Exception $e) {
            $deleted = false;

        }
        return new JsonResponse(array('deleted' => $deleted));
    }

    /**
     * @param $title
     * @return JsonResponse
     * @Route("back-office/slider/{title}/check_unique", name="slider_check_unique", options = { "expose" = true })
     * @Method({"GET","POST"})
     */
    public function findByTitleAction($title)
    {
        $slider = $this->getDoctrine()
            ->getManager()
            ->getRepository('GrifoflexTunisieBundle:Slider')
            ->findOneBy(array('title' => $title));

        $exists = true;

        if ($slider === null)
            $exists = false;

        return new JsonResponse(array('exists' => $exists));
    }


}
