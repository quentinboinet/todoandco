<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class TaskController extends AbstractController
{
    /**
     * @Route("/tasks", name="task_list")
     */
    public function listAction(EntityManagerInterface $em, TaskRepository $repository)
    {
        return $this->render('task/list.html.twig', ['tasks' => $repository->findBy(array('user' => $this->getUser()->getId(), 'isDone' => 0), ['createdAt' => 'DESC'])]);
    }

    /**
     * @Route("/tasks/archive", name="task_archive")
     */
    public function listDoneAction(EntityManagerInterface $em, TaskRepository $repository)
    {
        return $this->render('task/list.html.twig', ['tasks' => $repository->findBy(array('user' => $this->getUser()->getId(), 'isDone' => 1), ['createdAt' => 'DESC'])]);
    }

    /**
     * @Route("/tasks/create", name="task_create")
     */
    public function createAction(Request $request, EntityManagerInterface $em)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

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
    public function editAction(Task $task, Request $request, EntityManagerInterface $em, Security $security)
    {
        if ($task->getUser() === $security->getUser()) {  //on vérifie que ce soit bien le propriétaire de la tâche qui souhaite la modifier
            $form = $this->createForm(TaskType::class, $task);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $em->flush();
                $this->addFlash('success', 'La tâche a bien été modifiée.');

                return $this->redirectToRoute('task_list');
            }

            return $this->render('task/edit.html.twig', [
                'form' => $form->createView(),
                'task' => $task,
            ]);
        }
        else {
            return $this->render('bundles/TwigBundle/Exception/error404.html.twig');
        }
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction(Task $task, EntityManagerInterface $em, Security $security)
    {
        if ($task->getUser() === $security->getUser()) {  //on vérifie que ce soit bien le propriétaire de la tâche qui souhaite la modifier
                $task->toggle(!$task->isDone());
                $em->flush();

                if ($task->isDone()) {
                    $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));
                    return $this->redirectToRoute('task_list');
                } else {
                    $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme non terminée.', $task->getTitle()));
                    return $this->redirectToRoute('task_archive');
                }
            }
            else {
                return $this->render('bundles/TwigBundle/Exception/error404.html.twig');
            }
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTaskAction(Task $task, EntityManagerInterface $em, Security $security)
    {
        if ($task->isDone()) {
            $route = 'task_archive';
        }
        else {
            $route = 'task_list';
        }
        $em->remove($task);
        $em->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');
       return $this->redirectToRoute($route);
    }
}
