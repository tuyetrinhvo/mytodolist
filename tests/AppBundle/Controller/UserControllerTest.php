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
namespace tests\AppBundle\Controller;

/**
 * Class UserControllerTest
 *
 * @category PHP_Class
 * @package  Tests\AppBundle\Controller
 * @author   trinhvo <ttvdep@gmail.com>
 * @license  License Name
 * @link     Link Name
 */
class UserControllerTest extends AbstractControllerTest
{
    /**
     * Function testListPageUser
     *
     * @return void
     */
    public function testListPageUser()
    {
        $this->logIn(['ROLE_ADMIN']);
        $this->client->request('GET', '/users');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());

        //echo $this->client->getResponse()->getContent();
    }

    /**
     * Function testCreateUser
     *
     * @return void
     */
    public function testCreateUser()
    {
        $this->logIn(['ROLE_ADMIN']);
        $crawler = $this->client->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form();

        $form['user[username]'] = 'user'.mt_rand();
        $form['user[email]'] = 'user'.mt_rand().'@tuyetrinhvt.fr';
        $form['user[password][first]'] = 'password';
        $form['user[password][second]'] = 'password';
        $form['user[roles]'] = ['ROLE_USER'];

        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertContains(
            'L\'utilisateur a bien été ajouté.',
            $this->client->getCrawler()->filter('.alert')->text()
        );

        //echo $this->client->getResponse()->getContent();
    }

    /**
     * Function testCreateUserInvalid
     *
     * @return void
     */
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

        $this->assertContains(
            'Vous devez saisir un nom d\'utilisateur',
            $this->client->getCrawler()->filter('.help-block')->text()
        );

        //echo $this->client->getResponse()->getContent();
    }

    /**
     * Function testEditUser
     *
     * @return void
     */
    public function testEditUser()
    {
        $this->logIn(['ROLE_ADMIN']);
        $crawler = $this->client->request('GET', '/users/1/edit');

        $form = $crawler->selectButton('Modifier')->form();

        $form['user[username]'] = 'user'.mt_rand();
        $form['user[email]'] = 'user'.mt_rand().'@tuyetrinhvt.fr';
        $form['user[password][first]'] = 'password';
        $form['user[password][second]'] = 'password';
        //$form['user[roles]'] = ['ROLE_USER'];

        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertContains(
            'L\'utilisateur a bien été modifié',
            $this->client->getCrawler()->filter('.alert')->text()
        );

        //echo $this->client->getResponse()->getContent();
    }

    /**
     * Function testEditUserInvalid
     *
     * @return void
     */
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

        $this->assertContains(
            'Les deux mots de passe doivent correspondre.',
            $this->client->getCrawler()->filter('.help-block')->text()
        );

        //echo $this->client->getResponse()->getContent();
    }

    /**
     * Function testUserAccessDenied
     *
     * @return void
     */
    public function testUserAccessDenied()
    {
        $this->logIn(['ROLE_USER']);

        $this->client->request('GET', '/users');

        $this->assertSame(403, $this->client->getResponse()->getStatusCode());

        //echo $this->client->getResponse()->getContent();
    }
}
