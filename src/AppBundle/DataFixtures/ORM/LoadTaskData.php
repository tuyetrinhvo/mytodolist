<?php
/**
 * Class Doc Comment
 *
 * PHP version 7.0
 *
 * @category PHP_Class
 * @package  AppBundle
 * @author   trinhvo <ttvdep@gmail.com>
 * @license  License Name
 * @link     Link Name
 */
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Task;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadTaskData
 *
 * @category PHP_Class
 * @package  AppBundle\DataFixtures\ORM
 * @author   trinhvo <ttvdep@gmail.com>
 * @license  License Name
 * @link     Link Name
 */
class LoadTaskData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Function load
     *
     * @param ObjectManager $manager Some argument description
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $task1 = new Task();
        $task1->setTitle("Tâche crée par auteur anonyme");
        $task1->setContent("Ancienne tâche ajoutée par auteur anonyme");

        $task2 = new Task();
        $task2->setTitle("Tâche crée par auteur anonyme");
        $task2->setContent("Deuxième ancienne tâche ajoutée par auteur anonyme");

        $task3 = new Task();
        $task3->setTitle("Tâche crée par auteur anonyme");
        $task3->setContent("Troisième ancienne tâche ajoutée par auteur anonyme");

        $task4 = new Task();
        $task4->setTitle("Tâche crée par auteur Admin");
        $task4->setContent("Quatrième tâche ajoutée par auteur Admin");
        $task4->setAuthor($this->getReference('myadmin'));

        $task5 = new Task();
        $task5->setTitle("Tâche crée par auteur User");
        $task5->setContent("Cinquièmre tâche ajoutée par auteur User");
        $task5->setAuthor($this->getReference('myuser'));

        $manager->persist($task1);
        $manager->persist($task2);
        $manager->persist($task3);
        $manager->persist($task4);
        $manager->persist($task5);
        $manager->flush();
    }

    /**
     * Function getOrder
     *
     * @return int
     */
    public function getOrder()
    {
        return 3;
    }
}
