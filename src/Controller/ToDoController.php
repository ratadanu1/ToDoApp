<?php

namespace App\Controller;

date_default_timezone_set('Europe/Bucharest');
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Task;
use App\Form\TaskCreateType;
use Symfony\Component\HttpFoundation\Request;

class ToDoController extends AbstractController
{
    #[Route('/tasks', name: 'app_tasks')]
    public function viewTasks(TaskRepository $taskRepository): Response
    {
        $tasks = $taskRepository->findAll();

        return $this->render('to_do/task_list.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    #[Route('/task/view/{id}', name: 'app_task')]
    public function viewTask(Task $task): Response
    {
        return $this->render('to_do/task_view.html.twig', [
            'task' => $task,
        ]);
    }

    #[Route('/task/delete/{id}', name: 'app_task_delete')]
    public function deleteTask(int $id, EntityManagerInterface $entityManager): Response
    {
        $task = $entityManager->getRepository(Task::class)->find($id);

        $entityManager->remove($task);
        $entityManager->flush();

        return $this->redirectToRoute('app_tasks');
    }

    #[Route('/task/create', name: 'app_task_create')]
    public function create(EntityManagerInterface $entityManager , Request $request): Response
    {
        $task= new Task();
        $form = $this->createForm(TaskCreateType::class, $task, [
            'method' => 'POST',
        ]);

        $form->handleRequest($request);
        if (!($form->isSubmitted() && $form->isValid())) {
            return $this->render('to_do/index.html.twig', [
                'task_form' => $form->createView(),
            ]);
        }
        $task = $form->getData();
        $task->setCreatedAt(new \DateTime());
        $entityManager->persist($task);
        $entityManager->flush();
        return $this->redirectToRoute('app_task_create');
    
    }

    #[Route('/task/edit/{id}', name: 'app_task_edit')]
    public function editTask(int $id, EntityManagerInterface $entityManager, Request $request): Response
    {
        $task = $entityManager->getRepository(Task::class)->find($id);
        $form = $this->createForm(TaskCreateType::class, $task, [
            'method' => 'POST',
        ]);

        $form->handleRequest($request);
        if (!($form->isSubmitted() && $form->isValid())) {
            return $this->render('to_do/index.html.twig', [
                'task_form' => $form->createView(),
            ]);
        }
        $task = $form->getData();
        $entityManager->persist($task);
        $entityManager->flush();
        return $this->redirectToRoute('app_tasks');
    }    

}