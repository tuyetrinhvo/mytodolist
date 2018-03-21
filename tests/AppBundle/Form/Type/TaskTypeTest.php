<?php

namespace tests\AppBundle\Form\Type;


use AppBundle\Entity\Task;
use AppBundle\Form\Type\TaskType;
use Symfony\Component\Form\Test\TypeTestCase;

class TaskTypeTest extends TypeTestCase
{
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
