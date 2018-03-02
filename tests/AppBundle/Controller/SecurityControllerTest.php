<?php

namespace Tests\AppBundle\Controller;


class SecurityControllerTest extends AbstractControllerTest
{
    public function testSecurityPage()
    {
        $this->client->request('GET', '/login');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    }
}