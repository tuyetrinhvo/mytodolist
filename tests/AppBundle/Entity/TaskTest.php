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
namespace tests\AppBundle\Entity;

use AppBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class TaskTest
 *
 * @category PHP_Class
 * @package  Tests\AppBundle\Entity
 * @author   trinhvo <ttvdep@gmail.com>
 * @license  License Name
 * @link     Link Name
 */
class TaskTest extends WebTestCase
{
    /**
     * Function testTask
     *
     * @return void
     */
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
