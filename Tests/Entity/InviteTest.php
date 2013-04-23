<?php
/**
 * This file is part of BcUserBundle.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserBundle\Tests\Entity;

use \Mockery as m;

use Bc\Bundle\UserBundle\Entity\Invite;

/**
 * InviteTest
 *
 * @category    Tests
 * @package     BcUserBundle
 * @subpackage  Entity
 * @author      Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright   2013 Florian Eckerstorfer
 * @license     http://opensource.org/licenses/MIT The MIT License
 * @group       unit
 */
class InviteTest extends \PHPUnit_Framework_TestCase
{
    /** @var Invite */
    private $invite;

    public function setUp()
    {
        $this->invite = new Invite();
    }

    /**
     * Tests the <code>__construct()</code> method.
     *
     * @covers Bc\Bundle\UserBundle\Entity\Invite::__construct()
     * @covers Bc\Bundle\UserBundle\Entity\Invite::getCode()
     */
    public function testConstruct_getCode()
    {
        $this->assertEquals(6, strlen($this->invite->getCode()));
    }

    /**
     * Tests the <code>setEmail()</code> and <code>getEmail()</code> methods.
     *
     * @covers Bc\Bundle\UserBundle\Entity\Invite::setEmail()
     * @covers Bc\Bundle\UserBundle\Entity\Invite::getEmail()
     */
    public function testSetEmail_getEmail()
    {
        $this->invite->setEmail('foo@example.com');
        $this->assertEquals('foo@example.com', $this->invite->getEmail());
    }

    /**
     * Tests the <code>send()</code> and <code>isSent()</code> methods.
     *
     * @covers Bc\Bundle\UserBundle\Entity\Invite::send()
     * @covers Bc\Bundle\UserBundle\Entity\Invite::isSent()
     */
    public function testSend_isSent()
    {
        $this->invite->send();
        $this->assertTrue($this->invite->isSent());
    }

    /**
     * Tests the <code>setUser()</code> and <code>getUser()</code> methods.
     *
     * @covers Bc\Bundle\UserBundle\Entity\Invite::setUser()
     * @covers Bc\Bundle\UserBundle\Entity\Invite::getUser()
     */
    public function testSetUser_getUser()
    {
        $user = m::mock('FOS\UserBundle\Model\UserInterface');
        $this->invite->setUser($user);
        $this->assertEquals($user, $this->invite->getUser());
    }

    /**
     * Tests the <code>setCreatedAt()</code> and <code>getCreatedAt()</code> methods.
     *
     * @covers Bc\Bundle\UserBundle\Entity\Invite::setCreatedAt()
     * @covers Bc\Bundle\UserBundle\Entity\Invite::getCreatedAt()
     */
    public function testSetCreatedAt_getCreatedAt()
    {
        $date = new \DateTime();
        $this->invite->setCreatedAt($date);
        $this->assertEquals($date, $this->invite->getCreatedAt());
    }

    /**
     * Tests the <code>setUdpatedAt()</code> and <code>getUpdatedAt()</code> methods.
     *
     * @covers Bc\Bundle\UserBundle\Entity\Invite::setUpdatedAt()
     * @covers Bc\Bundle\UserBundle\Entity\Invite::getUpdatedAt()
     */
    public function testSetUpdatedAt_getUpdatedAt()
    {
        $date = new \DateTime();
        $this->invite->setUpdatedAt($date);
        $this->assertEquals($date, $this->invite->getUpdatedAt());
    }
}
