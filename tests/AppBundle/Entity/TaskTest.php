<?php

namespace tests\AppBundle\Entity;

use AppBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskTest extends WebTestCase
{
    public function testTask()
    {
        $task = new Task();
        $task->setTitle('A TaskTest');
        $task->setContent('Create a new task test');
        $task->setCreatedAt('2018-03-04 18:30:00');


        $this->assertSame('A TaskTest', $task->getTitle());
        $this->assertSame('Create a new task test', $task->getContent());
        $this->assertSame('2018-03-04 18:30:00', $task->getCreatedAt());
    }
}
