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


}