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
namespace tests\AppBundle\Form\Type;

use AppBundle\Entity\Task;
use AppBundle\Form\Type\TaskType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * Class TaskTypeTest
 *
 * @category PHP_Class
 * @package  Tests\AppBundle\Form\Type
 * @author   trinhvo <ttvdep@gmail.com>
 * @license  License Name
 * @link     Link Name
 */
class TaskTypeTest extends TypeTestCase
{
    /**
     * Function testSubmitValidData
     *
     * @return void
     */
    public function testSubmitValidData()
    {
        $formData = [
            'title' => 'Title Test',
            'content' => 'Content Test',
        ];

        $form = $this->factory->create(TaskType::class);

        $object = new Task();
        $object->setTitle($formData['title']);
        $object->setContent($formData['content']);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object->getTitle(), $form->get('title')->getData());
        $this->assertEquals($object->getContent(), $form->get('content')->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
