<?php
/**
 * Class Doc Comment
 *
 * PHP version 7.0
 *
 * @category PHP_Class
 * @package  AppBundle
 * @author   trinhvo <ttvdep@gmail.com>
 * @license  License Name
 * @link     Link Name
 */
namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\Type\TaskType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class TaskController
 *
 * @category PHP_Class
 * @package  AppBundle\Controller
 * @author   trinhvo <ttvdep@gmail.com>
 * @license  License Name
 * @link     Link Name
 */
class TaskController extends Controller
{
    /**
     * Function listTaskAction
     *
     * @Route("/tasks", name="task_list")
     * @Method({"GET"})
     *
     * @return Response
     */
    public function listTaskAction()
    {
        return $this->render(
            'task/list.html.twig', [
            'tasks' => $this->getDoctrine()
                ->getRepository('AppBundle:Task')
                ->findAll()
            ]
        );
    }

    /**
     * Function createTaskAction
     *
     * @param Request $request Some argument description
     *
     * @Route("/tasks/create", name="task_create")
     * @Method({"GET",         "POST"})
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createTaskAction(Request $request)
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

        return $this->render(
            'task/create.html.twig', [
            'form' => $form->createView()
            ]
        );
    }

    /**
     * Function editTaskAction
     *
     * @param Task    $task    Some argument description
     * @param Request $request Some argument description
     *
     * @Route("/tasks/{id}/edit", name="task_edit")
     * @Method({"GET",            "POST"})
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editTaskAction(Task $task, Request $request)
    {
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render(
            'task/edit.html.twig',
            [
            'form' => $form->createView(),
            'task' => $task,
            ]
        );
    }

    /**
     * Function toogleTaskAction
     *
     * @param Task $task Some argument description
     *
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     * @Method({"GET",              "POST"})
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function toggleTaskAction(Task $task)
    {
        $task->toggle(!$task->isDone());
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash(
            'success', sprintf(
                'La tâche %s a bien été marquée comme faite.',
                $task->getTitle()
            )
        );

        return $this->redirectToRoute('task_list');
    }

    /**
     * Function deleteTaskAction
     *
     * @param Task $task Some argument description
     *
     * @Route("/tasks/{id}/delete", name="task_delete")
     * @Method({"GET",              "POST"})
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteTaskAction(Task $task)
    {
        // anonymous author
        if ($task->getAuthor()===null||$task->getAuthor()->getUsername()==='anonyme'
        ) {

            if (!$this->get(
                'security.authorization_checker'
            )->isGranted('ROLE_ADMIN')
            ) {

                $this->addFlash(
                    'error',
                    'Vous ne pouvez pas supprimer cette tâche car
                     vous n\'êtes pas administrateur.'
                );

                return $this->redirectToRoute('task_list');
            }

        } elseif ($task->getAuthor()->getUsername() !== $this->get(
            'security.token_storage'
        )->getToken()->getUser()->getUsername()
        ) {

            $this->addFlash(
                'error',
                'Vous ne pouvez pas supprimer cette tâche car
                 vous n\'êtes pas son auteur.'
            );

            return $this->redirectToRoute('task_list');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
