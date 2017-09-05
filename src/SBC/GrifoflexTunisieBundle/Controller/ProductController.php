<?php

namespace SBC\GrifoflexTunisieBundle\Controller;

use SBC\GrifoflexTunisieBundle\Entity\Product;
use SBC\GrifoflexTunisieBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProductController
 * @package SBC\GrifoflexTunisieBundle\Controller
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class ProductController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Route("back-office/products/", name="product_index", options = { "expose" = true })
     * @Method({"GET","POST"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('GrifoflexTunisieBundle:Product')->findAll();

        return $this->render('@GrifoflexTunisie/product/index.html.twig', array(
            'products' => $products
        ));
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("back-office/product/new", name="product_new")
     * @Method({"GET","POST"})
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_show', array('id' => $product->getId()));
        }

        return $this->render('@GrifoflexTunisie/Product/new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("back-office/product/{id}", name="product_show")
     * @Method({"GET","POST"})
     */
    public function showAction(Product $product)
    {

        return $this->render('@GrifoflexTunisie/Product/show.html.twig', array(
            'product' => $product
        ));
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("back-office/product/{id}/edit", name="product_edit")
     * @Method({"GET","POST"})
     */
    public function editAction(Request $request, Product $product)
    {

        $editForm = $this->createForm(ProductType::class, $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em = $this->getDoctrine()->getManager();
            foreach ($product->getPictures() as $picture) {
                if ($picture->getDescription() == null) {
                    $product->removePicture($picture);
                    $em->remove($picture);
                } else {
                    $product->addPicture($picture);
                }
            }
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_show', array('id' => $product->getId()));
        }

        return $this->render('@GrifoflexTunisie/Product/edit.html.twig', array(
            'product' => $product,
            'form' => $editForm->createView()
        ));
    }

    /**
     * @param Product $product
     * @return JsonResponse
     * @Route("back-office/product/{id}", name="product_delete", options = { "expose" = true })
     * @Method("DELETE")
     */
    public function deleteAction(Product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $deleted = true;

        try {
            $em->remove($product);
            $em->flush();
        } catch (\Exception $e) {
            $deleted = false;

        }
        return new JsonResponse(array('deleted' => $deleted));
    }

    /**
     * @param $title
     * @return JsonResponse
     * @Route("back-office/product/{title}/check_unique", name="product_check_unique", options = { "expose" = true })
     * @Method({"GET","POST"})
     */
    public function findByTitleAction($title)
    {
        $product = $this->getDoctrine()
            ->getManager()
            ->getRepository('GrifoflexTunisieBundle:Product')
            ->findOneBy(array('title' => $title));

        $exists = true;

        if ($product === null)
            $exists = false;

        return new JsonResponse(array('exists' => $exists));
    }


}
