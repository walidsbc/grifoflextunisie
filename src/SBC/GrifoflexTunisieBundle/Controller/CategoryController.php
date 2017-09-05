<?php

namespace SBC\GrifoflexTunisieBundle\Controller;

use SBC\GrifoflexTunisieBundle\Entity\Category;
use SBC\GrifoflexTunisieBundle\Form\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class CategoryController
 * @package SBC\GrifoflexTunisieBundle\Controller
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class CategoryController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("back-office/categories/", name="category_index")
     * @Method({"GET","POST"})
     */
    public function indexAction()
    {

        $categories = $this->getDoctrine()->getManager()->getRepository('GrifoflexTunisieBundle:Category')->findAll();

        return $this->render('@GrifoflexTunisie/category/index.html.twig', array(
            'categories' => $categories
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("category/new", name="category_new")
     * @Method({"GET","POST"})
     */
    public function newAction(Request $request)
    {

        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('category_show', array('id' => $category->getId()));
        }

        return $this->render('@GrifoflexTunisie/category/new.html.twig', array(
            'category' => $category,
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("back-office/category/{id}", name="category_show")
     * @Method({"GET","POST"})
     */
    public function showAction(Category $category)
    {

        return $this->render('@GrifoflexTunisie/category/show.html.twig', array(
            'category' => $category

        ));
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("back-office/category/{id}/edit", name="category_edit")
     * @Method({"GET","POST"})
     */
    public function editAction(Request $request, Category $category)
    {

        $editForm = $this->createForm(CategoryType::class, $category);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('category_show', array('id' => $category->getId()));
        }

        return $this->render('@GrifoflexTunisie/category/edit.html.twig', array(
            'category' => $category,
            'form' => $editForm->createView(),

        ));
    }

    /**
     * @param Category $category
     * @return JsonResponse
     * @Route("back-office/category/{id}", name="category_delete", options = { "expose" = true })
     * @Method("DELETE")
     */
    public function deleteAction(Category $category)
    {
        $em = $this->getDoctrine()->getManager();
        $deleted = true;

        try {
            $em->remove($category);
            $em->flush();
        } catch (\Exception $e) {
            $deleted = false;

        }
        return new JsonResponse(array('deleted' => $deleted));
    }

    /**
     * @param $title
     * @return JsonResponse
     * @Route("back-office/category/{title}/check_unique", name="category_check_unique", options = { "expose" = true })
     * @Method({"GET","POST"})
     */
    public function findByTitleAction($title)
    {
        $event = $this->getDoctrine()
            ->getManager()
            ->getRepository('GrifoflexTunisieBundle:Category')
            ->findOneBy(array('title' => $title));

        $exists = true;

        if ($event === null)
            $exists = false;

        return new JsonResponse(array('exists' => $exists));
    }


}