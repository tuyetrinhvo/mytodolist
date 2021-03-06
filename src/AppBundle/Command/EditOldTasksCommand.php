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
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Entity\User;

/**
 * Class EditOldTasksCommand
 *
 * @category PHP_Class
 * @package  AppBundle\Command
 * @author   trinhvo <ttvdep@gmail.com>
 * @license  License Name
 * @link     Link Name
 */
class EditOldTasksCommand extends ContainerAwareCommand
{
    /**
     * Function configure
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('update:old:tasks')
            ->setDescription('Update old tasks : link them to an anonymous user');
    }

    /**
     * Function execute
     *
     * @param InputInterface  $input  Some argument description
     * @param OutputInterface $output Some argument description
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $oldTasks = $entityManager->getRepository(
            'AppBundle:Task'
        )->findByAuthor(null);

        if (!empty($oldTasks)) {
            $userAnonyme = new User();
            $userAnonyme->setUsername('anonyme');
            $userAnonyme->setEmail('anonyme@anonyme.com');
            $userAnonyme->setPassword('anonyme');
            $entityManager->persist($userAnonyme);

            foreach ($oldTasks as $task) {
                $task->setAuthor($userAnonyme);
            }
            $entityManager->flush();

            $output->writeln('Old Tasks are updated !');
        } else {
            $output->writeln('Old Tasks are updated !');
        }
    }
}
