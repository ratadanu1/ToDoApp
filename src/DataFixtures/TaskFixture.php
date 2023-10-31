<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Task;
use App\Entity\Category;


class TaskFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = new Category();
        $category->setName("test_category");
        $task = new Task();
        $task->setTitle("test task");
        $task->setCategoryId($category);
        $task->setdueDate(new \DateTime());
        $task->setDescription("test description");
        $task->setCreatedAt(new \DateTime());

        $manager->flush();
    }
}
