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
        return $this->render('task/list.html.twig', ['tasks' => $this->getDoctrine()->getRepository('AppBundle:Task')->findAll()]);
    }

    /**
     * @Route("/tasks/create", name="task_create")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $task->setAuthor($this->getUser());

            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Task $task, Request $request)
    {
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render(
            'task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
            ]
        );
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     * @Method({"GET", "POST"})
     */
    public function toggleTaskAction(Task $task)
    {
        $task->toggle(!$task->isDone());
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteTaskAction(Task $task)
    {
        // anonymous author
        if($task->getAuthor() === null || $task->getAuthor()->getUsername() === 'anonyme') {
            if(!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

                $this->addFlash('error', 'Vous ne pouvez pas supprimer cette tâche car vous n\'êtes pas administrateur.');

                return $this->redirectToRoute('task_list');
            }

        } elseif ($task->getAuthor()->getUsername() !== $this->get('security.token_storage')->getToken()->getUser()->getUsername()) {

            $this->addFlash('error', 'Vous ne pouvez pas supprimer cette tâche car vous n\'êtes pas son auteur.');

            return $this->redirectToRoute('task_list');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}

