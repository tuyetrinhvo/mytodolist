<?php

namespace tests\AppBundle\Controller;


class UserControllerTest extends AbstractControllerTest
{

    public function testListPageUser()
    {
        $this->logIn(['ROLE_ADMIN']);
        $this->client->request('GET', '/users');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());

        //echo $this->client->getResponse()->getContent();
    }

    public function testCreateUser()
    {
        $this->logIn(['ROLE_ADMIN']);
        $crawler = $this->client->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form();

        $form['user[username]'] = 'tuyetrinh';
        $form['user[email]'] = 'tuyetrinh@tuyetrinhvt.fr';
        $form['user[password][first]'] = 'password';
        $form['user[password][second]'] = 'password';
        $form['user[roles]'] = ['ROLE_USER'];

        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertContains('L\'utilisateur a bien été ajouté.', $this->client->getCrawler()->filter('.alert')->text());

        //echo $this->client->getResponse()->getContent();
    }

    public function testCreateUserInvalid()
    {
        $this->logIn(['ROLE_ADMIN']);
        $crawler = $this->client->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form();

        $form['user[username]'] = '';
        $form['user[email]'] = 'ttrinh@tuyetrinhvt.fr';
        $form['user[password][first]'] = 'password';
        $form['user[password][second]'] = 'password';
        $form['user[roles]'] = ['ROLE_USER'];

        $this->client->submit($form);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertContains('Vous devez saisir un nom d\'utilisateur', $this->client->getCrawler()->filter('.help-block')->text());

        //echo $this->client->getResponse()->getContent();
    }

    public function testEditUser()
    {
        $this->logIn(['ROLE_ADMIN']);
        $crawler = $this->client->request('GET', '/users/1/edit');

        $form = $crawler->selectButton('Modifier')->form();

        $form['user[username]'] = 'ttrinh';
        $form['user[email]'] = 'ttrinh@tuyetrinhvt.fr';
        $form['user[password][first]'] = 'password';
        $form['user[password][second]'] = 'password';
        //$form['user[roles]'] = ['ROLE_USER'];

        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertContains('L\'utilisateur a bien été modifié', $this->client->getCrawler()->filter('.alert')->text());

        //echo $this->client->getResponse()->getContent();
    }

    public function testEditUserInvalid()
    {
        $this->logIn(['ROLE_ADMIN']);
        $crawler = $this->client->request('GET', '/users/1/edit');

        $form = $crawler->selectButton('Modifier')->form();

        $form['user[username]'] = 'tuyetrinh';
        $form['user[email]'] = 'tuyetrinh@tuyetrinhvt.com';
        $form['user[password][first]'] = 'password';
        $form['user[password][second]'] = 'password_password';
        //$form['user[roles]'] = ['ROLE_USER'];

        $this->client->submit($form);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertContains('Les deux mots de passe doivent correspondre.', $this->client->getCrawler()->filter('.help-block')->text());

        //echo $this->client->getResponse()->getContent();
    }

}