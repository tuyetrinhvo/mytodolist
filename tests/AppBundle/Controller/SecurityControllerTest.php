<?php

namespace Tests\AppBundle\Controller;


class SecurityControllerTest extends AbstractControllerTest
{
    public function testSecurityPage()
    {
        $this->client->request('GET', '/login');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    }

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

        $this->assertContains('Invalid credentials.', $this->client->getCrawler()->filter('.alert')->text());

        //echo $this->client->getResponse()->getContent();
    }

    public function testLogIn()
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();

        $form['_username'] = 'admin';
        $form['_password'] = 'zsx';

        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertContains('Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !', $this->client->getCrawler()->filter('h1')->text()
        );

        //echo $this->client->getResponse()->getContent();
    }
}