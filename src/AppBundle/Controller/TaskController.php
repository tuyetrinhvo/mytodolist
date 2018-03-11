<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\Type\TaskType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class TaskController extends Controller
{
    /**
     * @Route("/tasks", name="task_list")
     * @Method({"GET"})
     */
    public function listAction()
    {
        $response = $this->render('task/list.html.twig', ['tasks' => $this->getDoctrine()->getRepository('AppBundle:Task')->findAll()]);

        $response->setSharedMaxAge(3600)->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }

    /**
     * @Route("/tasks/create", name="task_create")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request, Response $response = null)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $task->setAuthor($this->getUser());

            $entityManager->persist($task);
            $entityManager->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            if($response){ $response->expire(); }

            return $this->redirectToRoute('task_list');
        }

        $newresponse = $this->render('task/create.html.twig', ['form' => $form->createView()]);

        $newresponse->setSharedMaxAge(3600)->headers->addCacheControlDirective('must-revalidate', true);

        return $newresponse;
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Task $task, Request $request,  Response $response = null)
    {
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            if($response){ $response->expire(); }

            return $this->redirectToRoute('task_list');
        }

        $newresponse = $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);

        $newresponse->setSharedMaxAge(3600)->headers->addCacheControlDirective('must-revalidate', true);

        return $newresponse;
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     * @Method({"GET", "POST"})
     */
    public function toggleTaskAction(Task $task, Response $response = null)
    {
        $task->toggle(!$task->isDone());
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        if($response){ $response->expire(); }

        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteTaskAction(Task $task, Response $response = null)
    {
        // anonymous author
        if($task->getAuthor() === null || $task->getAuthor()->getUsername() === 'anonyme')
        {
            if(!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

                $this->addFlash('error', 'Vous ne pouvez pas supprimer cette tâche car vous n\'êtes pas administrateur.');

                if($response){ $response->expire(); }

                return $this->redirectToRoute('task_list');
            }

        } elseif ($task->getAuthor()->getUsername() !== $this->get('security.token_storage')->getToken()->getUser()->getUsername()) {

            $this->addFlash('error', 'Vous ne pouvez pas supprimer cette tâche car vous n\'êtes pas son auteur.');

            if($response){ $response->expire(); }

            return $this->redirectToRoute('task_list');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($task);
        $entityManager->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        if($response){ $response->expire(); }

        return $this->redirectToRoute('task_list');
    }
}
