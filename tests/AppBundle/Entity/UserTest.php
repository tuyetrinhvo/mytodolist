<?php

namespace tests\AppBundle\Entity;


use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
    public function testUser()
    {

        $user = new User();
        $user->setUsername('myusername');
        $user->setPassword('mypassword');
        $user->setEmail('myemail@todolist.com');
        $user->setRoles(['ROLE_USER']);

        $this->assertSame('myusername', $user->getUsername());
        $this->assertSame('mypassword', $user->getPassword());
        $this->assertEquals('myemail@todolist.com', $user->getEmail());
        $this->assertSame(['ROLE_USER'], $user->getRoles());


    }
}
