<?php

namespace SBC\GrifoflexFrontBundle\Controller;


use SBC\GrifoflexTunisieBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Class ProductController
 * @package SBC\GrifoflexFrontBundle\Controller
 * @Route("/", requirements={"_locale": "fr|en"})
 */
class ProductController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("{_locale}/products", name="product_products", options = { "expose" = true })
     * @Method({"GET","POST"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('GrifoflexTunisieBundle:Product')->findAll();

        $categories = $em->getRepository('GrifoflexTunisieBundle:Category')->findAll();

        return $this->render('@Grifoflex/product/products.html.twig', array(
            'products' => $products,
            'categories' => $categories
        ));
    }



    /**
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("{_locale}/product/{id}", name="product_view")
     * @Method({"GET","POST"})
     */
    public function showAction(Product $product)
    {

        return $this->render('@Grifoflex/product/product.html.twig', array(
            'product' => $product
        ));
    }



}
