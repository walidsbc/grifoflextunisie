<?php

namespace SBC\GrifoflexTunisieBundle\Controller;

use SBC\GrifoflexTunisieBundle\Entity\ApplicationMail;
use SBC\GrifoflexTunisieBundle\Form\ApplicationMailType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApplicationMailController
 * @package SBC\GrifoflexTunisieBundle\Controller
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class ApplicationMailController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("back-office/application-mails", name="application_mail_index", options = { "expose" = true })
     * @Method({"GET","POST"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $applicationMails = $em->getRepository('GrifoflexTunisieBundle:ApplicationMail')->findAll();

        return $this->render('@GrifoflexTunisie/applicationMail/index.html.twig', array(
            'applicationMails' => $applicationMails,
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("back-office/application-mail/new", name="application_mail_new")
     * @Method({"GET","POST"})
     */
    public function newAction(Request $request)
    {
        $applicationMail = new ApplicationMail();
        $form = $this->createForm(ApplicationMailType::class, $applicationMail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($applicationMail);
            $em->flush();

            return $this->redirectToRoute('application_mail_index');
        }

        return $this->render('@GrifoflexTunisie/applicationMail/new.html.twig', array(
            'applicationMail' => $applicationMail,
            'form' => $form->createView(),
        ));
    }


    /**
     * @param Request $request
     * @param ApplicationMail $applicationMail
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("back-office/application-mail/{id}/edit", name="application_mail_edit")
     * @Method({"GET","POST"})
     */
    public function editAction(Request $request, ApplicationMail $applicationMail)
    {

        $editForm = $this->createForm(ApplicationMailType::class, $applicationMail);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('application_mail_index' );
        }

        return $this->render('@GrifoflexTunisie/applicationMail/edit.html.twig', array(
            'applicationMail' => $applicationMail,
            'form' => $editForm->createView()
        ));
    }

    /**
     * @param ApplicationMail $applicationMail
     * @return JsonResponse
     * @Route("back-office/application-mail/{id}", name="application_mail_delete", options = { "expose" = true })
     * @Method("DELETE")
     */
    public function deleteAction(ApplicationMail $applicationMail)
    {
        $em = $this->getDoctrine()->getManager();
        $deleted = true;
        try {
            $em->remove($applicationMail);
            $em->flush();
        } catch (\Exception $e) {
            $deleted = false;
        }
        return new JsonResponse(array('deleted' => $deleted));
    }


    /**
     * @param $mail
     * @return JsonResponse
     * @Route("back-office/application-mail/{mail}/check_unique", name="application_mail_check_unique", options = { "expose" = true })
     * @Method({"GET","POST"})
     */
    public function findByMailAction($mail)
    {
        $applicationMail = $this->getDoctrine()
            ->getManager()
            ->getRepository('GrifoflexTunisieBundle:ApplicationMail')
            ->findOneBy(array('mailAddress' => $mail));

        $exists = true;

        if ($applicationMail === null)
            $exists = false;

        return new JsonResponse(array('exists' => $exists));
    }

}
