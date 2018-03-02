<?php

namespace Tests\AppBundle\Controller;


class TaskControllerTest extends AbstractControllerTest
{
    public function testListPageTask()
    {
        $this->client->request('GET', '/tasks');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testListPageTaskLogIn()
    {
        $this->logIn(['ROLE_USER']);

        $this->client->request('GET', '/tasks');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        //echo $this->client->getResponse()->getContent();
    }

    public function testCreateTask()
    {
        $this->logIn(['ROLE_USER']);

        $crawler = $this->client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();

        $form['task[title]'] = 'Title For Test';
        $form['task[content]'] = 'Content For Test';

        $this->client->submit($form);

        $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertContains('La tâche a été bien été ajoutée.', $this->client->getCrawler()->filter('.alert')->text());

        //echo $this->client->getResponse()->getContent();
    }

    public function testCreateTaskInvalid()
    {
        $this->logIn(['ROLE_USER']);

        $crawler = $this->client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();

        $form['task[title]'] = '';
        $form['task[content]'] = 'Content For Test';

        $this->client->submit($form);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertContains('Vous devez saisir un titre.', $this->client->getCrawler()->filter('.help-block')->text());

        //echo $this->client->getResponse()->getContent();
    }

    public function testEditTask()
    {
        //$this->testCreateTask();

        $this->logIn(['ROLE_USER']);

        $crawler = $this->client->request('GET', '/tasks/1/edit');

        $form = $crawler->selectButton('Modifier')->form();

        $form['task[title]'] = 'Title modified For Test';
        $form['task[content]'] = 'Content modified For Test';

        $this->client->submit($form);

        $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertContains('La tâche a bien été modifiée.', $this->client->getCrawler()->filter('.alert')->text());

        //echo $this->client->getResponse()->getContent();
    }

    public function testEditTaskInvalid()
    {
        //$this->testCreateTask();

        $this->logIn(['ROLE_USER']);

        $crawler = $this->client->request('GET', '/tasks/1/edit');

        $form = $crawler->selectButton('Modifier')->form();

        $form['task[title]'] = 'Title modified For Test';
        $form['task[content]'] = '';

        $this->client->submit($form);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertContains('Vous devez saisir du contenu.', $this->client->getCrawler()->filter('.help-block')->text());

        //echo $this->client->getResponse()->getContent();
    }

    public function testEditTask404()
    {
        $this->logIn(['ROLE_USER']);

        $this->client->request('GET', '/tasks/20/edit');

        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());

        //echo $this->client->getResponse()->getContent();
    }

    public function testToggleTask()
    {
        //$this->testCreateTask();

        $this->logIn(['ROLE_USER']);

        $this->client->request('POST', '/tasks/1/toggle');

        $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertSame(1, $this->client->getCrawler()->filter('.alert')->count());

        //echo $this->client->getResponse()->getContent();
    }

    public function testDeleteTaskError()
    {
        //$this->testCreateTask();

        $this->logIn(['ROLE_USER']);

        $this->client->request('GET', '/tasks/1/delete');

        $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertContains('Vous ne pouvez pas supprimer cette tâche car vous n\'êtes pas administrateur.', $this->client->getCrawler()->filter('.alert')->text());

        //echo $this->client->getResponse()->getContent();
    }

    public function testDeleteTask()
    {
        //$this->testCreateTask();

        $this->logIn(['ROLE_ADMIN']);

        $this->client->request('GET', '/tasks/1/delete');

        $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertContains('La tâche a bien été supprimée.', $this->client->getCrawler()->filter('.alert')->text());

        //echo $this->client->getResponse()->getContent();
    }



}