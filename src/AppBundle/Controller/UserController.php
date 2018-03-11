<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class UserController extends Controller
{
    /**
     * @Route("/users", name="user_list")
     * @Method({"GET"})
     */
    public function listAction()
    {
        $response = $this->render('user/list.html.twig', ['users' => $this->getDoctrine()->getRepository('AppBundle:User')->findAll()]);

        $response->setSharedMaxAge(3600)->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }

    /**
     * @Route("/users/create", name="user_create")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request, Response $response = null)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            if($response){ $response->expire(); }

            return $this->redirectToRoute('user_list');
        }

        $newresponse = $this->render('user/create.html.twig', ['form' => $form->createView()]);

        $newresponse->setSharedMaxAge(3600)->headers->addCacheControlDirective('must-revalidate', true);

        return $newresponse;
    }

    /**
     * @Route("/users/{id}/edit", name="user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(User $user, Request $request, Response $response = null)
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "L'utilisateur a bien été modifié");

            if($response){ $response->expire(); }

            return $this->redirectToRoute('user_list');
        }

        $newresponse = $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);

        $newresponse->setSharedMaxAge(3600)->headers->addCacheControlDirective('must-revalidate', true);

        return $newresponse;
    }
}
