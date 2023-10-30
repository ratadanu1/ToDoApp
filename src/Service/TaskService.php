<?php

namespace App\Service;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class TaskService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createTask($title, $description, $date, $category): Task
    {
        $task = new Task();
        $task->setTitle($title);
        $task->setDescription($description);
        $task->setDueDate($date);
        $task->setCreatedAt(new \DateTime());
        $task->setCategoryId($category);

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return $task;
    }

    //edit task method
    public function editTask($id, $title, $description, $date, $category): Task
    {
        $task = $this->entityManager->getRepository(Task::class)->find($id);

        $task->setTitle($title);
        $task->setDescription($description);
        $task->setDueDate($date);
        $task->setCategoryId($category);

        $this->entityManager->flush();

        return $task;
    }

    //task list method
    public function getTaskList()
    {
        $taskRepository = $this->entityManager->getRepository(Task::class);
        $tasks = $taskRepository->findAll();

        return $tasks;
    }

    // delete task method
    public function deleteTask($id): void
    {
        $task = $this->entityManager->getRepository(Task::class)->find($id);

        $this->entityManager->remove($task);
        $this->entityManager->flush();
    }
}
