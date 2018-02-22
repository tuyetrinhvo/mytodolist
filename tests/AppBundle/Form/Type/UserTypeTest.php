<?php

namespace tests\AppBundle\Form\Type;


use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;
use Symfony\Component\Form\Test\TypeTestCase;

class UserTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = [
            'username' => 'myusername',
            'password' => ['first' => 'mypassword', 'second' => 'mypassword'],
            'email' => 'myemail@todolist.com'
        ];

        $form = $this->factory->create(UserType::class);

        $object = new User();
        $object->setUsername('myusername');
        $object->setPassword('mypassword');
        $object->setEmail('myemail@todolist.com');


        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object->getUsername(), $form->get('username')->getData());
        $this->assertEquals($object->getPassword(), $form->get('password')->getData());
        $this->assertEquals($object->getEmail(), $form->get('email')->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}