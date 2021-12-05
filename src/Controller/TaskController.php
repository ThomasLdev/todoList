<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tasks")
 */
class TaskController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/", name="task_list", methods={"GET"})
     */
    public function index(TaskRepository $taskRepository): Response
    {
        if (in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            $tasks = $taskRepository->findBy(['user' => null]);
        } else {
            $tasks = $this->getUser()->getTasks();
        }
        return $this->render('task/index.html.twig', [
            'tasks' => $tasks
        ]);
    }

    /**
     * @Route("/create", name="task_create", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setUser($this->getUser());
            $this->em->persist($task);
            $this->em->flush();

            return $this->redirectToRoute('task_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('task/new.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="task_edit", methods={"GET", "POST"})
     * @IsGranted("TASK_EDIT", subject="task"),
     * message="Vous ne pouvez pas modifier une tâche qui ne vous appartient pas =/"
     */
    public function edit(Request $request, Task $task): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('task_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('task/edit.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/toggle", name="task_toggle")
     * @IsGranted("TASK_TOGGLE", subject="task"),
     * message="Vous ne pouvez pas modifier une tâche qui ne vous appartient pas =/"
     */
    public function toggleTaskAction(Task $task): RedirectResponse
    {
        if ($task->getUser() === $this->getUser()) {
            $task->toggle(!$task->isDone());
            $this->em->flush();
            $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));
        } else {
            throw $this->createAccessDeniedException();
        }
        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/{id}/delete", name="task_delete", methods={"POST"})
     * @IsGranted("TASK_DELETE", subject="task"),
     * message="Vous ne pouvez pas modifier une tâche qui ne vous appartient pas =/"
     */
    public function delete(Request $request, Task $task): Response
    {
        $this->em->remove($task);
        $this->em->flush();
        $this->addFlash('success', "La tache '".$task->getTitle()."' a bien été supprimée !");
        return $this->redirectToRoute('task_list', [], Response::HTTP_SEE_OTHER);
    }
}
