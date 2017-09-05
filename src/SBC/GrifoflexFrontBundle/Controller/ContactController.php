<?php

namespace SBC\GrifoflexFrontBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ContactController
 * @package SBC\GrifoflexFrontBundle\Controller
 * @Route("{_locale}/", requirements={"_locale": "fr|en"})
 */
class ContactController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("contact/send/", name="contact_send")
     * @Method({"POST"})
     */
    public function sendAction(Request $request)
    {




        $listmail = array();
        $emails = $this->getDoctrine()->getRepository('GrifoflexTunisieBundle:ContactMail')->findAll();
        foreach ($emails as $email) {
            array_push($listmail, $email->getMailAddress());
        }

        $message = \Swift_Message::newInstance()
            ->setSubject('Contact: ' . $request->request->get('subject'))
            ->setFrom($request->request->get('email'))
            ->setTo($listmail)
            ->setBody($request->request->get('message'),
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

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("contact/", name="contact_index")
     * @Method({"GET","POST"})
     */
    public function contactAction()
    {

        return $this->render('@Grifoflex/contact/contact.html.twig');
    }

    /**
     * @param $email
     * @return int
     */
    public function isEmail($email)
    {
        return (preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $email));

    }

}
