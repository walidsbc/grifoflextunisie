<?php

namespace SBC\GrifoflexFrontBundle\Controller;


use Dompdf\Dompdf;
use Dompdf\Options;
use SBC\GrifoflexTunisieBundle\Entity\Quotation;
use SBC\GrifoflexTunisieBundle\Form\QuotationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class QuotationController
 * @package SBC\GrifoflexTunisieBundle\Controller
 * @Route("/", requirements={"_locale": "fr|en"})
 */
class QuotationController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("{_locale}/quotation/new", name="quotation_new", options = { "expose" = true })
     * @Method({"GET","POST"})
     */
    public function newAction(Request $request)
    {
        $quotation = new Quotation();
        $form = $this->createForm(QuotationType::class, $quotation);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($quotation);
            $em->flush();

            $message = \Swift_Message::newInstance()
                ->setSubject('Quotation: ' . $request->request->get('subject'))
                ->setFrom($quotation->getEmail())
                ->setTo($quotation->getEmail())
                ->setBody(new Response($this->pdfAction($quotation), 200, array('Content-Type' => 'application/pdf')),
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

        return $this->render('@Grifoflex/quotation/new.html.twig', array(
            'quotation' => $quotation,
            'form' => $form->createView(),
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("{_locale}/quotation/view", name="quotation_view")
     * @Method({"GET","POST"})
     */

    public function pdfAction($quotation)
    {
        $view = $this->renderView('@Grifoflex/quotation/pdf.html.twig', array('quotation' => $quotation));

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $d = new Dompdf($options);
        $contxt = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);
        $d->setHttpContext($contxt);
        $d->loadHtml($view);

        // Render the HTML as PDF
        $d->render();

        // Output the generated PDF to Browser
        $d->stream('file.pdf', array(
            'Attachment' => 0,
        ));



    }

}
