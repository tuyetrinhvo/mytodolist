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

use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;
use tests\AppBundle\Controller\AbstractControllerTest;

/**
 * Class UserTypeTest
 *
 * @category PHP_Class
 * @package  Tests\AppBundle\Form\Type
 * @author   trinhvo <ttvdep@gmail.com>
 * @license  License Name
 * @link     Link Name
 */
class UserTypeTest extends AbstractControllerTest
{
    /**
     * Function testSubmitValidData
     *
     * @return void
     */
    public function testSubmitValidData()
    {
        $formData = [
            'username' => 'myusername',
            'password' => ['first' => 'mypassword', 'second' => 'mypassword'],
            'email' => 'myemail@todolist.com'
        ];

        $factory = $this->container->get('form.factory');

        $form = $factory->create(UserType::class);

        $object = new User();
        $object->setUsername('myusername');
        $object->setPassword('mypassword');
        $object->setEmail('myemail@todolist.com');


        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals(
            $object->getUsername(),
            $form->get('username')->getData()
        );
        $this->assertEquals(
            $object->getPassword(),
            $form->get('password')->getData()
        );
        $this->assertEquals($object->getEmail(), $form->get('email')->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
