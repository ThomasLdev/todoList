<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends Controller
{
    /**
     * @Route("/tasks", name="task_list")
     */
    public function listAction()
    {
        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {
            $tasks = $this->getDoctrine()->getRepository('AppBundle:Task')->findBy(['user' => null]);
        } else {
            $tasks = $this->getDoctrine()->getRepository('AppBundle:Task')->findBy(['user' => $this->getUser()]);
        }

        return $this->render('task/list.html.twig', ['tasks' => $tasks]);
    }

    /**
     * @Route("/tasks/create", name="task_create")
     */
    public function createAction(Request $request)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $task->setUser($this->getUser());
            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    public function editAction(Task $task, Request $request)
    {
        if ($task->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($task->getUser() == $this->getUser()) {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', 'La tâche a bien été modifiée.');
            }
            return $this->redirectToRoute('task_list');
        }
        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction(Task $task)
    {
        if ($task->getUser() == $this->getUser()) {
            $task->toggle(!$task->isDone());
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));
        } else {
            throw $this->createAccessDeniedException();
        }
        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTaskAction(Task $task)
    {
        if ($task->getUser() == $this->getUser()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($task);
            $em->flush();
            $this->addFlash('success', 'La tâche a bien été supprimée.');
        } else {
            throw $this->createAccessDeniedException();
        }
        return $this->redirectToRoute('task_list');
    }
}
