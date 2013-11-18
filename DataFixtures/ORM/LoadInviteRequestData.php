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
class LoadInviteRequestData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /** @var array */
    private $inviteRequests = array(
        array('email' => 'user1@example.com', 'deletedAt' => '-1 week'),
        array('email' => 'user-a@example.com'),
        array('email' => 'user-b@example.com'),
        array('email' => 'user-c@example.com'),
        array('email' => 'user-d@example.com'),
        array('email' => 'user-e@example.com')
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
        $manager = $this->container->get('braincrafted_user.invite_request_manager');

        foreach ($this->inviteRequests as $inviteRequestData) {
            $inviteRequest = $manager->createInviteRequest();
            $inviteRequest->setEmail($inviteRequestData['email']);
            if (isset($inviteRequestData['deletedAt'])) {
                $inviteRequest->setDeletedAt(new \DateTime($inviteRequestData['deletedAt']));
            }
            $manager->updateInviteRequest($inviteRequest, false);
        }

        $this->container->get('doctrine.orm.entity_manager')->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}