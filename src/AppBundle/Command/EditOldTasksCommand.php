<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Entity\User;

class EditOldTasksCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('update:old:tasks')
            ->setDescription('Update old tasks : link them to an anonymous user')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $oldTasks = $em->getRepository('AppBundle:Task')->findByAuthor(null);

        if (!empty($oldTasks)) {

            $userAnonyme = new User();
            $userAnonyme->setUsername('anonyme');
            $userAnonyme->setEmail('anonyme@anonyme.com');
            $userAnonyme->setPassword('anonyme');
            $em->persist($userAnonyme);

            foreach ($oldTasks as $task) { $task->setAuthor($userAnonyme); }
            $em->flush();

            $output->writeln('Old Tasks are updated !');

        } else {
            $output->writeln('Old Tasks were already updated !');
        }
    }
}