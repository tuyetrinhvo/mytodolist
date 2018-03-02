<?php

namespace tests\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserControllerTest extends WebTestCase
{

    private $client = null;


    protected function setUp()
    {
        $this->client = static::createClient();


    }
    public function testListPage()
    {
        $this->logIn();
        $this->client->request('GET', '/users');



        $this->assertSame(200, $this->client->getResponse()->getStatusCode());

        //echo $this->client->getResponse()->getContent();
    }

    public function testCreateUser()
    {

        $this->logIn();
        $crawler = $this->client->request('GET', '/users/create');


            //recover the form to fill it
        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'trinh';
        $form['user[email]'] = 'trinh@tuyetrinhvt.fr';
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

    }

    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        $firewallContext = 'main';

        $token = new UsernamePasswordToken('mailys', null, $firewallContext, array('ROLE_ADMIN'));

        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    public function tearDown()
    {
        $this->client = null;

    }
}