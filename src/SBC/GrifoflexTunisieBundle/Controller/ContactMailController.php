<?php

namespace SBC\GrifoflexTunisieBundle\Controller;

use SBC\GrifoflexTunisieBundle\Entity\ContactMail;
use SBC\GrifoflexTunisieBundle\Form\ContactMailType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ContactMailController
 * @package SBC\GrifoflexTunisieBundle\Controller
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class ContactMailController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("back-office/contact-mails/", name="contact_mail_index", options = { "expose" = true })
     * @Method({"GET","POST"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contactMails = $em->getRepository('GrifoflexTunisieBundle:ContactMail')->findAll();

        return $this->render('@GrifoflexTunisie/contactMail/index.html.twig', array(
            'contactMails' => $contactMails,
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("back-office/contact-mail/new", name="contact_mail_new")
     * @Method({"GET","POST"})
     */
    public function newAction(Request $request)
    {
        $contactMail = new Contactmail();
        $form = $this->createForm(ContactMailType::class, $contactMail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contactMail);
            $em->flush();

            return $this->redirectToRoute('contact_mail_index');
        }

        return $this->render('@GrifoflexTunisie/contactMail/new.html.twig', array(
            'contactMail' => $contactMail,
            'form' => $form->createView(),
        ));
    }


    /**
     * @param Request $request
     * @param ContactMail $contactMail
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("back-office/contact-mail/{id}/edit", name="contact_mail_edit")
     * @Method({"GET","POST"})
     */
    public function editAction(Request $request, ContactMail $contactMail)
    {

        $editForm = $this->createForm(ContactMailType::class, $contactMail);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contact_mail_index' );
        }

        return $this->render('@GrifoflexTunisie/contactMail/edit.html.twig', array(
            'contactMail' => $contactMail,
            'form' => $editForm->createView()
        ));
    }

    /**
     * @param ContactMail $contactMail
     * @return JsonResponse
     * @Route("back-office/contact-mail/{id}", name="contact_mail_delete", options = { "expose" = true })
     * @Method("DELETE")
     */
    public function deleteAction(ContactMail $contactMail)
    {
        $em = $this->getDoctrine()->getManager();
        $deleted = true;
        try {
            $em->remove($contactMail);
            $em->flush();
        } catch (\Exception $e) {
            $deleted = false;
        }
        return new JsonResponse(array('deleted' => $deleted));
    }


    /**
     * @param $mail
     * @return JsonResponse
     * @Route("back-office/contact-mail/{mail}/check_unique", name="contact_mail_check_unique", options = { "expose" = true })
     * @Method({"GET","POST"})
     */
    public function findByMailAction($mail)
    {
        $contactMail = $this->getDoctrine()
            ->getManager()
            ->getRepository('GrifoflexTunisieBundle:ContactMail')
            ->findOneBy(array('mailAddress' => $mail));

        $exists = true;

        if ($contactMail === null)
            $exists = false;

        return new JsonResponse(array('exists' => $exists));
    }

}
