<?php
/**
 * Class Doc Comment
 *
 * PHP version 7.0
 *
 * @category PHP_Class
 * @package  Tests
 * @author   trinhvo <ttvdep@gmail.com>
 * @license  License Name
 * @link     Link Name
 */
namespace Tests\AppBundle\Command;

use AppBundle\Command\EditOldTasksCommand;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class EditOldTasksTest
 *
 * @category PHP_Class
 * @package  Tests\AppBundle\Command
 * @author   trinhvo <ttvdep@gmail.com>
 * @license  License Name
 * @link     Link Name
 */
class EditOldTasksTest extends KernelTestCase
{
    /**
     * Function testExecuteCommand
     *
     * @return void
     */
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
