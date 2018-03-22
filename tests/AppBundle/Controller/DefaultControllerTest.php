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
namespace Tests\AppBundle\Controller;
/**
 * Class DefaultControllerTest
 *
 * @category PHP_Class
 * @package  Tests\AppBundle\Controller
 * @author   trinhvo <ttvdep@gmail.com>
 * @license  License Name
 * @link     Link Name
 */
class DefaultControllerTest extends AbstractControllerTest
{
    /**
     * Function testIndex
     *
     * @return void
     */
    public function testIndex()
    {
        $this->client->request('GET', '/');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        //echo $this->client->getResponse()->getContent();
    }

    /**
     * Function testIndexLogIn
     *
     * @return void
     */
    public function testIndexLogIn()
    {
        $this->logIn(['ROLE_USER']);

        $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        //echo $this->client->getResponse()->getContent();
    }
}
