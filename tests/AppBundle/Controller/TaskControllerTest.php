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

use AppBundle\Entity\Task;
use AppBundle\Entity\User;

/**
 * Class TaskControllerTest
 *
 * @category PHP_Class
 * @package  Tests\AppBundle\Controller
 * @author   trinhvo <ttvdep@gmail.com>
 * @license  License Name
 * @link     Link Name
 */
class TaskControllerTest extends AbstractControllerTest
{
    /**
     * Function testListPageTask
     *
     * @return void
     */
    public function testListPageTask()
    {
        $this->client->request('GET', '/tasks');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Function testListPageTaskLogIn
     *
     * @return void
     */
    public function testListPageTaskLogIn()
    {
        $this->logIn(['ROLE_USER']);

        $this->client->request('GET', '/tasks');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        //echo $this->client->getResponse()->getContent();
    }

    /**
     * Function testCreateTask
     *
     * @return void
     */
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

        $this->assertContains(
            'La tâche a été bien été ajoutée.',
            $this->client->getCrawler()->filter('.alert')->text()
        );

        //echo $this->client->getResponse()->getContent();
    }

    /**
     * Function testCreateTaskInvalid
     *
     * @return void
     */
    public function testCreateTaskInvalid()
    {
        $this->logIn(['ROLE_USER']);

        $crawler = $this->client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();

        $form['task[title]'] = '';
        $form['task[content]'] = 'Content For Test';

        $this->client->submit($form);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertContains(
            'Vous devez saisir un titre.',
            $this->client->getCrawler()->filter('.help-block')->text()
        );

        //echo $this->client->getResponse()->getContent();
    }

    /**
     * Function testEditTask
     *
     * @return void
     */
    public function testEditTask()
    {
        $this->logIn(['ROLE_USER']);

        $crawler = $this->client->request('GET', '/tasks/1/edit');

        $response = $this->client->getResponse()->getStatusCode();

        if ($this->client->getResponse()->isNotFound()) {
            $this->assertSame(404, $response);
        } else {
            $form = $crawler->selectButton('Modifier')->form();

            $form['task[title]'] = 'Title modified For Test';
            $form['task[content]'] = 'Content modified For Test';

            $this->client->submit($form);

            $this->client->followRedirect();

            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

            $this->assertContains(
                'La tâche a bien été modifiée.',
                $this->client->getCrawler()->filter('.alert')->text()
            );
        }

        //echo $this->client->getResponse()->getContent();
    }

    /**
     * Function testEditTaskInvalid
     *
     * @return void
     */
    public function testEditTaskInvalid()
    {
        $this->logIn(['ROLE_USER']);

        $crawler = $this->client->request('GET', '/tasks/1/edit');

        $response = $this->client->getResponse()->getStatusCode();

        if ($this->client->getResponse()->isNotFound()) {
            $this->assertSame(404, $response);
        } else {
            $form = $crawler->selectButton('Modifier')->form();

            $form['task[title]'] = 'Title modified For Test';
            $form['task[content]'] = '';

            $this->client->submit($form);

            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

            $this->assertContains(
                'Vous devez saisir du contenu.',
                $this->client->getCrawler()->filter('.help-block')->text()
            );
        }

        //echo $this->client->getResponse()->getContent();
    }

    /**
     * Function testEditTask404
     *
     * @return void
     */
    public function testEditTask404()
    {
        $this->logIn(['ROLE_USER']);

        $this->client->request('GET', '/tasks/200/edit');

        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());

        //echo $this->client->getResponse()->getContent();
    }

    /**
     * Function testToggleTask
     *
     * @return void
     */
    public function testToggleTask()
    {
        $this->logIn(['ROLE_USER']);

        $this->client->request('POST', '/tasks/1/toggle');

        $response = $this->client->getResponse()->getStatusCode();

        if ($this->client->getResponse()->isNotFound()) {
            $this->assertSame(404, $response);
        } else {
            $this->assertSame(302, $response);

            $this->client->followRedirect();

            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

            $this->assertSame(
                1, $this->client->getCrawler()->filter(
                    '.alert'
                )->count()
            );
        }

        //echo $this->client->getResponse()->getContent();
    }

    /**
     * Function testDeleteTaskErrorAnonymous
     *
     * @return void
     */
    public function testDeleteTaskErrorAnonymous()
    {
        $this->logIn(['ROLE_USER']);

        $this->client->request('GET', '/tasks/1/delete');

        $response = $this->client->getResponse()->getStatusCode();

        if ($this->client->getResponse()->isNotFound()) {
            $this->assertSame(404, $response);
        } else {
            $this->assertSame(302, $response);

            $this->client->followRedirect();

            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

            $this->assertContains(
                'Vous ne pouvez pas supprimer 
            cette tâche car vous n\'êtes pas administrateur.',
                $this->client->getCrawler()->filter('.alert')->text()
            );
        }

        //echo $this->client->getResponse()->getContent();
    }

    /**
     * Function testDeleteTaskErrorAuthor
     *
     * @return void
     */
    public function testDeleteTaskErrorAuthor()
    {
        $this->createTaskForTest();

        $this->logInForTest();

        $this->client->request('GET', '/tasks/2/delete');

        $response = $this->client->getResponse()->getStatusCode();

        if ($this->client->getResponse()->isNotFound()) {
            $this->assertSame(404, $response);
        } else {
            $this->assertSame(302, $response);

            $this->client->followRedirect();

            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

            $this->assertContains(
                'Vous ne pouvez pas supprimer 
            cette tâche car vous n\'êtes pas son auteur.',
                $this->client->getCrawler()->filter('.alert')->text()
            );
        }

        //echo $this->client->getResponse()->getContent();
    }

    /**
     * Function testDeleteTask
     *
     * @return void
     */
    public function testDeleteTask()
    {
        $this->logIn(['ROLE_ADMIN']);

        $this->client->request('GET', '/tasks/1/delete');

        $response = $this->client->getResponse()->getStatusCode();

        if ($this->client->getResponse()->isNotFound()) {
            $this->assertSame(404, $response);
        } else {
            $this->assertSame(302, $response);

            $this->client->followRedirect();

            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

            $this->assertContains(
                'La tâche a bien été supprimée.',
                $this->client->getCrawler()->filter('.alert')->text()
            );
        }

        //echo $this->client->getResponse()->getContent();
    }
}
