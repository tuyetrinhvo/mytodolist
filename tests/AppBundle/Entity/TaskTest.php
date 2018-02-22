<?php

namespace tests\AppBundle\Entity;


use AppBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskTest extends WebTestCase
{
    public function testTask(){

        $task = new Task();
        $task->setTitle('A TaskTest');
        $task->setContent('Create a new task test');

        $this->assertSame('A TaskTest', $task->getTitle());
        $this->assertSame('Create a new task test', $task->getContent());


    }
}