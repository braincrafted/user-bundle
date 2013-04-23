<?php
/**
 * This file is part of BcUserBundle.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserBundle\Tests\Entity;

use \Mockery as m;

use Bc\Bundle\UserBundle\Entity\User;

/**
 * UserTest
 *
 * @category    Tests
 * @package     BcUserBundle
 * @subpackage  Entity
 * @author      Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright   2013 Florian Eckerstorfer
 * @license     http://opensource.org/licenses/MIT The MIT License
 * @group       unit
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    /** @var User */
    private $user;

    public function setUp()
    {
        $this->user = new User();
    }

    /**
     * Tests the <code>setId()</code> and <code>getId()</code> methods.
     *
     * @covers Bc\Bundle\UserBundle\Entity\User::setId()
     * @covers Bc\Bundle\UserBundle\Entity\User::getId()
     */
    public function testSetId_getId()
    {
        $this->user->setId(42);
        $this->assertEquals(42, $this->user->getId());
    }

    /**
     * Tests the <code>expiresAt() method.
     *
     * @covers Bc\Bundle\UserBundle\Entity\User::getExpiresAt()
     */
    public function testGetExpiresAt()
    {
        $date = new \DateTime();
        $this->user->setExpiresAt($date);
        $this->assertEquals($date, $this->user->getExpiresAt());
    }

    /**
     * Tests the <code>setInvite()</code> and <code>getInvite()</code> methods.
     *
     * @covers Bc\Bundle\UserBundle\Entity\User::setInvite()
     * @covers Bc\Bundle\UserBundle\Entity\User::getInvite()
     */
    public function testSetInvite_getInvite()
    {
        $invite = m::mock('Bc\Bundle\UserBundle\Entity\Invite');
        $this->user->setInvite($invite);
        $this->assertEquals($invite, $this->user->getInvite());
    }
}
