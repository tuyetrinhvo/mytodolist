<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends AbstractControllerTest
{
    public function testIndex()
    {

        $this->client->request('GET', '/');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

    }
}
