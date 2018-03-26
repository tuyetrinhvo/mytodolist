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
 * Class SecurityControllerTest
 *
 * @category PHP_Class
 * @package  Tests\AppBundle\Controller
 * @author   trinhvo <ttvdep@gmail.com>
 * @license  License Name
 * @link     Link Name
 */
class SecurityControllerTest extends AbstractControllerTest
{
    /**
     * Function testSecurityPage
     *
     * @return void
     */
    public function testSecurityPage()
    {
        $this->client->request('GET', '/login');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Function testLogInInvalid
     *
     * @return void
     */
    public function testLogInInvalid()
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();

        $form['_username'] = 'trinh';
        $form['_password'] = 'password';

        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertContains(
            'Invalid credentials.',
            $this->client->getCrawler()->filter('.alert')->text()
        );

        //echo $this->client->getResponse()->getContent();
    }

    /**
     * Function testLogIn
     *
     * @return void
     */
    public function testLogIn()
    {
        $this->logInForTest();

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertContains(
            "Bienvenue sur Todo List, l'application vous permettant de gérer l'ensemble de vos tâches sans effort !",
            $this->client->getCrawler()->filter('h1')->text()
        );

        //echo $this->client->getResponse()->getContent();
    }
}
