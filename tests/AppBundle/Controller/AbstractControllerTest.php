<?php

namespace tests\AppBundle\Controller;


use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

abstract class AbstractControllerTest extends WebTestCase
{
    protected $entityManager;
    protected $client;
    protected $container;

    protected function setUp()
    {
        $this->client = static::createClient();
        $this->container = $this->client->getContainer();
        $this->entityManager = $this->container->get('doctrine')->getManager();
    }

    protected function logIn($roles)
    {
        $session = $this->container->get('session');

        $firewallContext = 'main';

        $token = new UsernamePasswordToken('trinh', null, $firewallContext, $roles);

        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    protected function createTaskForTest()
    {
        $this->logIn(['ROLE_USER']);

        $user = new User();
        $user->setUsername('user'.mt_rand());
        $user->setEmail('user'.mt_rand().'@tuyetrinhvt.fr');
        $user->setPassword('$2y$13$iXry06pcJt5nrOlsHUnavuzcvieJL5FwNQ2oi7s6vtxrgyn3EtiBW');
        $user->setRoles(['ROLE_USER']);
        $this->entityManager->persist($user);


        $task = new Task();
        $task->setTitle('task for test');
        $task->setContent('task content');
        $task->setAuthor($user);
        $this->entityManager->persist($task);

        $this->entityManager->flush();
    }

    protected function logInForTest()
    {
        $this->logIn(['ROLE_ADMIN']);

        $crawler = $this->client->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form();

        $form['user[username]'] = 'mailys';
        $form['user[email]'] = 'mailys@tuyetrinhvt.fr';
        $form['user[password][first]'] = 'zsx';
        $form['user[password][second]'] = 'zsx';
        $form['user[roles]'] = ['ROLE_USER'];

        $this->client->submit($form);

        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();

        $form['_username'] = 'mailys';
        $form['_password'] = 'zsx';

        $this->client->submit($form);
    }

    protected function tearDown()
    {
        $this->client = null;
        $this->container = null;
        $this->entityManager = null;
    }
}
