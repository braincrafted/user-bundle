<?php
/**
 * This file is part of BcUserBundle.
 * (c) 2013 Florian Eckerstiorfer
 */

namespace Bc\Bundle\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * LoadUserData
 *
 * @category   DoctrineORMDataFixtures
 * @package    BcUserBundle
 * @subpackage DataFixtures
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 */
class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /** @var array */
    private $users = array(
        array(
            'username'  => 'admin',
            'password'  => 'admin',
            'email'     => 'admin@example.com',
            'role'      => 'ROLE_ADMIN'
        ),
        array(
            'username'  => 'user1',
            'password'  => 'user1',
            'email'     => 'user1@example.com',
            'role'      => 'ROLE_USER'
        )
    );

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $manager = $this->container->get('bc_user.user_manager');

        foreach ($this->users as $userData) {
            $user = $manager->createUser();
            $user->setUsername($userData['username']);
            $user->setPlainPassword($userData['password']);
            $user->setEmail($userData['email']);
            $user->setRoles(array($userData['role']));
            $user->setEnabled(true);
            $manager->updateUser($user, false);
        }

        $this->container->get('doctrine.orm.entity_manager')->flush();
    }
}