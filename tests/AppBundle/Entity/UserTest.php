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

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class UserTest
 *
 * @category PHP_Class
 * @package  Tests\AppBundle\Entity
 * @author   trinhvo <ttvdep@gmail.com>
 * @license  License Name
 * @link     Link Name
 */
class UserTest extends WebTestCase
{
    /**
     * Function testUser
     *
     * @return void
     */
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
