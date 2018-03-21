<?php

namespace Tests\AppBundle\Command;

use AppBundle\Command\EditOldTasksCommand;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;


class EditOldTasksTest extends KernelTestCase
{
    public function testExecuteCommand()
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $application->add(new EditOldTasksCommand());

        $command = $application->find('update:old:tasks');

        $commandTester = new CommandTester($command);

        $commandTester->execute(
            [
            'command'  => $command->getName()]
        );

        $output = $commandTester->getDisplay();
        $this->assertContains('Old Tasks are updated !', $output);
    }
}
