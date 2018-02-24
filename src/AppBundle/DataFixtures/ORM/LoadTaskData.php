<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Task;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class LoadTaskData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $task1 = new Task();
        $task1->setTitle("Une tâche sans auteur");
        $task1->setContent("Tâche ajoutée par datafixtures");

        $task2 = new Task();
        $task2->setTitle("Deuxième tâche sans auteur");
        $task2->setContent("Deuxième tâche ajoutée par datafixtures");

        $task3 = new Task();
        $task3->setTitle("Tâche crée par auteur User");
        $task3->setContent("Troisième tâche ajoutée par datafixtures");
        $task3->setAuthor($this->getReference('myuser'));

        $task4 = new Task();
        $task4->setTitle("Tâche crée par auteur Admin");
        $task4->setContent("Quatrième tâche ajoutée par datafixtures");
        $task4->setAuthor($this->getReference('myadmin'));

        $manager->persist($task1);
        $manager->persist($task2);
        $manager->persist($task3);
        $manager->persist($task4);
        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}