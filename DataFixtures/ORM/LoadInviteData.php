<?php
/**
 * This file is part of BraincraftedUserBundle.
 * (c) 2013 Florian Eckerstiorfer
 */

namespace Braincrafted\Bundle\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * LoadUserData
 *
 * @category   DoctrineORMDataFixtures
 * @package    BraincraftedUserBundle
 * @subpackage DataFixtures
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 */
class LoadInviteData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /** @var array */
    private $invites = array(
        array(
            'email'     => 'admin@example.com',
            'sent'      => true,
            'user'      => 'admin'
        ),
        array(
            'email'     => 'user1@example.com',
            'sent'      => true,
            'user'      => 'user1'
        ),
        array(
            'email'     => 'user2@example.com',
            'sent'      => true
        ),
        array('email' => 'user3@example.com'),
        array()
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
        $manager = $this->container->get('braincrafted_user.invite_manager');

        foreach ($this->invites as $inviteData) {
            $invite = $manager->createInvite();
            if (isset($inviteData['email'])) {
                $invite->setEmail($inviteData['email']);
            }
            if (isset($inviteData['user'])) {
                $invite->setUser($this->getReference(sprintf('user-%s', $inviteData['user'])));
            }
            if (isset($inviteData['sent']) && $inviteData['sent']) {
                $invite->send();
            }
            $manager->updateInvite($invite, false);
        }

        $this->container->get('doctrine.orm.entity_manager')->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}