<?php

namespace tests\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

abstract class AbstractControllerTest extends WebTestCase
{
    protected $client;
    protected $container;

    protected function setUp()
    {
        $this->client = static::createClient();
        $this->container = $this->client->getContainer();
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

    protected function tearDown()
    {
        $this->client = null;
        $this->container = null;
    }
}