<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Task;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class LoadTaskData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $task1 = new Task();
        $task1->setTitle("Test d'une tâche !");
        $task1->setContent("Ajout d'une tâche grace aux data-fixtures.");

        $task2 = new Task();
        $task2->setTitle("Test d'une autre tâche");
        $task2->setContent("Ajout d'une seconde tâche !");

        $manager->persist($task1);
        $manager->persist($task2);
        $manager->flush();
    }

}