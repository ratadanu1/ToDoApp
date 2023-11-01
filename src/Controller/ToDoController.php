<?php

namespace App\Controller;

use Knp\Component\Pager\PaginatorInterface;

date_default_timezone_set('Europe/Bucharest');
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Task;
use App\Form\TaskCreateType;
use Symfony\Component\HttpFoundation\Request;
use App\Service\TaskService;

class ToDoController extends AbstractController
{
    private $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    #[Route('/tasklist', name: 'app_task_list')]
    public function viewTaskList(PaginatorInterface $paginator, Request $request): Response
    {
        $task_list = $this->taskService->getTaskList();

        $list = $paginator->paginate(
            $task_list,
            $request->query->getInt('page', 1),
            3
        );

        return $this->render('to_do/task_list.html.twig', [
            'tasklist' => $list,
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
    public function deleteTask(int $id): Response
    {
        $task = $this->taskService->deleteTask($id);

        return $this->redirectToRoute('app_task_list');
    }

    #[Route('/task/create', name: 'app_task_create')]
    public function create(Request $request): Response
    {
        $form = $this->createForm(TaskCreateType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $title = $form->get('title')->getData();
            $description = $form->get('description')->getData();
            $date = $form->get('dueDate')->getData();
            $category = $form->get('category_id')->getData();

            $this->taskService->createTask($title, $description, $date, $category);

            return $this->redirectToRoute('app_task_list');
        }

        return $this->render('to_do/index.html.twig', [
            'task_form' => $form->createView(),
        ]);

    }

    #[Route('/task/edit/{id}', name: 'app_task_edit')]
    public function edit(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TaskCreateType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $title = $form->get('title')->getData();
            $description = $form->get('description')->getData();
            $date = $form->get('dueDate')->getData();
            $category = $form->get('category_id')->getData();

            $this->taskService->editTask($id, $title, $description, $date, $category);

            return $this->redirectToRoute('app_task_list');
        }

        return $this->render('to_do/index.html.twig', [
            'task_form' => $form->createView(),
        ]);
    }
}