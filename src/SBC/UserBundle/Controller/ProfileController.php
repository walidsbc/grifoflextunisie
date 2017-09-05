<?php

namespace SBC\UserBundle\Controller;

use FOS\UserBundle\Controller\ProfileController as BaseController;

use SBC\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class add method show profile in fosuserbundle
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class ProfileController extends BaseController
{

    /**
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("back-office/utilisateur/{id}", name="user_show", options = { "expose" = true })
     * @Method({"GET","POST"})
     */

    public function showUserAction(User $user)
    {
        return $this->render('UserBundle:Profile:show.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * Current user
     */
    public function showAction()
    {

        $user = $this->getUser();

        if (!is_object($user) || !$user instanceof User) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->render('UserBundle:Profile:show.html.twig', array(
            'user' => $user
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("back-office/utilisateurs", name="user_index", options = { "expose" = true })
     * @Method({"GET","POST"})
     */
    public function indexAction()
    {

        $users = $this->getDoctrine()->getManager()->getRepository('UserBundle:User')->findAll();

        return $this->render('UserBundle:Profile:users.html.twig', array(
                'users' => $users
            )
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * Current user
     * @Route("back-office/utilisateur/profil/edit", name="fos_user_profile_edit")
     * @Method({"GET","POST"})
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();

        if (!is_object($user) || !$user instanceof User) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $form = $this->createForm(\SBC\UserBundle\Form\Type\ProfileFormType::class, $user);
        $form->setData($user);
        $form->handleRequest($request);
        $roles = $user->getRoles();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setRoles($roles);
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updatePassword($user);

            $em->flush();
            return $this->redirect($this->generateUrl('fos_user_profile_show'));
        }

        return $this->render('UserBundle:Profile:edit.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));


    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("back-office/utilisateur/{id}/edit", name="user_edit")
     * @Method({"GET","POST"})
     */
    public function editUserAction(Request $request, User $user)
    {
        $form = $this->createForm(\SBC\UserBundle\Form\Type\ProfileEditFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updatePassword($user);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('user_show', array('id' => $user->getId()));
        }

        return $this->render('@User/Profile/editUser.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),

        ));
    }

    /**
     * @param User $user
     * @return JsonResponse
     * @Route("back-office/utilisateur/{id}/delete", name="user_delete", options = { "expose" = true })
     * @Method({"DELETE"})
     */
    public function deleteAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $deleted = true;


        try {
            $em->remove($user);
            $em->flush();
        } catch (\Exception $e) {
            $deleted = false;

        }
        return new JsonResponse(array('deleted' => $deleted));
    }

    /**
     * @param User $user
     * @return JsonResponse
     * @Route("back-office/utilisateur/{id}/enable-or-disable", name="user_enable_or_disable", options = { "expose" = true })
     * @Method({"GET","POST"})
     */
    public function enableOrDisableUserAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $success = true;


        $user->setEnabled(!$user->isEnabled());
        try {
            $em->persist($user);
            $em->flush();
        } catch (\Exception $e) {
            $success = false;

        }
        return new JsonResponse(array('success' => $success));
    }

    /**
     * @param $mail
     * @return JsonResponse
     * @Route("back-office/utilisateur/{mail}/check_unique", name="user_mail_check_unique", options = { "expose" = true })
     * @Method({"GET","POST"})
     */
    public function getUserByEmailAction($mail)
    {
        $user = $this->getDoctrine()
            ->getManager()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('email' => $mail));

        $exists = true;
        if ($user === null)
            $exists = false;

        return new JsonResponse(array('exists' => $exists));
    }

    /**
     * @param $username
     * @return JsonResponse
     * @Route("back-office/utilisateur/{username}/check_unique", name="user_username_check_unique", options = { "expose" = true })
     * @Method({"GET","POST"})
     */
    public function getUserByUserNameAction($username)
    {
        $user = $this->getDoctrine()
            ->getManager()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('username' => $username));

        $exists = true;

        if ($user === null)
            $exists = false;

        return new JsonResponse(array('exists' => $exists));
    }
}
