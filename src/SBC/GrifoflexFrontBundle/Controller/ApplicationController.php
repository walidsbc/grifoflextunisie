<?php

namespace SBC\GrifoflexFrontBundle\Controller;


use SBC\GrifoflexTunisieBundle\Entity\Application;
use SBC\GrifoflexTunisieBundle\Form\ApplicationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ApplicationController
 * @package SBC\GrifoflexFrontBundle\Controller
 */
class ApplicationController extends Controller
{


    /**
     * @param Request $request
     * @return Request|\Symfony\Component\HttpFoundation\Response
     * @Route("{_locale}/application/new", name="application_new")
     * @Method({"GET","POST"})
     */
    public function newAction(Request $request)
    {
        $application = new Application();
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($application);
            $em->flush();

            $this->sendMail($application);

        }

        return $this->render('@Grifoflex/application/new.html.twig', array(
            'application' => $application,
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Application $application
     * @return Response
     */
    public function sendMail(Application $application)
    {
        $listmail = array();
        $emails = $this->getDoctrine()->getRepository('GrifoflexTunisieBundle:ApplicationMail')->findAll();
        foreach ($emails as $email) {
            array_push($listmail, $email->getMailAddress());
        }

        $message = \Swift_Message::newInstance()
            ->setSubject('Candidature: ' . $application->getFullName())
            ->setFrom($application->getEmail())
            ->setTo($listmail)
            ->setBody($application->getNote(),
                'text/html'
            );

        if ($this->get('mailer')->send($message)) {
            return new Response(
                'true'
            );
        } else {
            return new Response(
                'false'
            );
        }

    }



}
