<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;


class LoadUserData extends AbstractFixture implements OrderedFixtureInterface,ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setUsername('user');
        $user1->setEmail('user@gmail.com');

        $password = 'aqw';
        $encoder = $this->container->get('security.password_encoder');
        $encodePass = $encoder->encodePassword($user1, $password);

        $user1->setPassword($encodePass);
        $user1->setRoles(['ROLE_USER']);

        $user2 = new User();
        $user2->setUsername('admin');
        $user2->setEmail('admin@gmail.com');

        $password2 = 'zsx';
        $encoder2 = $this->container->get('security.password_encoder');
        $encodePass2 = $encoder2->encodePassword($user2, $password2);

        $user2->setPassword($encodePass2);
        $user2->setRoles(['ROLE_ADMIN']);

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}