<?php

namespace tests\AppBundle\Controller;


class UserControllerTest extends AbstractControllerTest
{

    public function testListPage()
    {
        $this->logIn(['ROLE_ADMIN']);
        $this->client->request('GET', '/users');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());

        //echo $this->client->getResponse()->getContent();
    }

    public function testCreateUser()
    {
        $this->logIn(['ROLE_ADMIN']);
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

}