<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ToDoController extends AbstractController
{
    #[Route('/to/do', name: 'app_to_do')]
    public function index(): Response
    {
        return $this->render('to_do/index.html.twig', [
            'controller_name' => 'ToDoController',
        ]);
    }

    #[Route('/to/do/{id}', name: 'app_to_do_show')]
    public function show($id): Response
    {
        return $this->render('to_do/show.html.twig', [
            'controller_name' => 'ToDoController',
            'id' => $id
        ]);
    }

    #[Route('/to/do/{id}/edit', name: 'app_to_do_edit')]
    public function edit($id): Response
    {
        return $this->render('to_do/edit.html.twig', [
            'controller_name' => 'ToDoController',
            'id' => $id
        ]);
    }

    #[Route('/to/do/{id}/delete', name: 'app_to_do_delete')]
    public function delete($id): Response
    {
        return $this->render('to_do/delete.html.twig', [
            'controller_name' => 'ToDoController',
            'id' => $id
        ]);
    }

    #[Route('/to/do/new', name: 'app_to_do_new')]
    public function new(): Response
    {
        return $this->render('to_do/new.html.twig', [
            'controller_name' => 'ToDoController',
        ]);
    }

    #[Route('/to/do/create', name: 'app_to_do_create')]
    public function create(): Response
    {
        return $this->render('to_do/create.html.twig', [
            'controller_name' => 'ToDoController',
        ]);
    }
}