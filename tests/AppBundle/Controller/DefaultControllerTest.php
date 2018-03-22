<?php

namespace Tests\AppBundle\Controller;

class DefaultControllerTest extends AbstractControllerTest
{
    public function testIndex()
    {
        $this->client->request('GET', '/');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        //echo $this->client->getResponse()->getContent();
    }

    public function testIndexLogIn()
    {
        $this->logIn(['ROLE_USER']);

        $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        //echo $this->client->getResponse()->getContent();
    }
}
