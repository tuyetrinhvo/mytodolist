<?php
/**
 * Class Doc Comment
 *
 * PHP version 7.0
 *
 * @category PHP_Class
 * @package  AppBundle
 * @author   trinhvo <ttvdep@gmail.com>
 * @license  License Name
 * @link     Link Name
 */
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadUserData
 *
 * @category PHP_Class
 * @package  AppBundle\DataFixtures\ORM
 * @author   trinhvo <ttvdep@gmail.com>
 * @license  License Name
 * @link     Link Name
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface,
    ContainerAwareInterface
{
    /**
     * Private variable container
     *
     * @var ContainerInterface
     */
    private $_container;

    /**
     * Function setContainer
     *
     * @param ContainerInterface|null $container Some argument description
     *
     * @return void
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->_container = $container;
    }

    /**
     * Function load
     *
     * @param ObjectManager $manager Some argument description
     *
     * @throws \Doctrine\Common\DataFixtures\BadMethodCallException
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $password = $this->_container->get('security.password_encoder');

        $user = new User();
        $user->setUsername('user');
        $user->setEmail('user@gmail.com');
        $user->setPassword($password->encodePassword($user, 'aqw'));
        $user->setRoles(['ROLE_USER']);

        $admin = new User();
        $admin->setUsername('admin');
        $admin->setEmail('admin@gmail.com');
        $admin->setPassword($password->encodePassword($admin, 'zsx'));
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);
        $manager->persist($admin);
        $manager->flush();

        $this->addReference('myuser', $user);
        $this->addReference('myadmin', $admin);
    }

    /**
     * Function getOrder
     *
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}
