<?php

namespace Tests\AppBundle\Command;

use AppBundle\Command\EditOldTasksCommand;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;


class EditOldTasksTest extends WebTestCase
{
    protected $em;
    protected $client;
    protected $container;

    public function setUp()
    {
        $this->client = static::createClient();

        $this->container = $this->client->getContainer();

        $this->em = $this->container->get('doctrine')->getManager();

        static $metadatas;

        if(!isset($metadatas)) {
            $metadatas = $this->em->getMetadataFactory()->getAllMetadata();
        }

        $schemaTool = new SchemaTool($this->em);

        $schemaTool->dropDatabase();

        if(!empty($metadatas)) {
            $schemaTool->createSchema($metadatas);
        }
    }

    public function testExecuteCommand()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);

        $application->add(new EditOldTasksCommand());

        $command = $application->find('update:old:tasks');

        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'command'  => $command->getName()]);

        $output = $commandTester->getDisplay();
        $this->assertContains('Old Tasks were already updated !', $output);
    }
}