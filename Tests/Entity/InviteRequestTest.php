<?php
/**
 * This file is part of BcUserBundle.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserBundle\Tests\Entity;

use Bc\Bundle\UserBundle\Entity\InviteRequest;

/**
 * InviteRequestTest
 *
 * @category    Tests
 * @package     BcUserBundle
 * @subpackage  Entity
 * @author      Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright   2013 Florian Eckerstorfer
 * @license     http://opensource.org/licenses/MIT The MIT License
 * @group       unit
 */
class InviteRequestTest extends \PHPUnit_Framework_TestCase
{
    /** @var InviteRequest */
    private $inviteRequest;

    public function setUp()
    {
        $this->inviteRequest = new InviteRequest();
    }

    /**
     * Tests the <code>__construct()</code> method.
     *
     * @covers Bc\Bundle\UserBundle\Entity\InviteRequest::__construct()
     */
    public function testConstructor()
    {
        $inviteRequest = new InviteRequest();
        $now = new \DateTime();
        $this->assertEquals($now->format('Y-m-d H:i:s'), $inviteRequest->getCreatedAt()->format('Y-m-d H:i:s'));
    }

    /**
     * Tests the <code>setEmail()</code> and <code>getEmail()</code> methods.
     *
     * @covers Bc\Bundle\UserBundle\Entity\InviteRequest::setEmail()
     * @covers Bc\Bundle\UserBundle\Entity\InviteRequest::getEmail()
     */
    public function testSetEmail_GetEmail()
    {
        $this->inviteRequest->setEmail('foo@example.com');
        $this->assertEquals('foo@example.com', $this->inviteRequest->getEmail());
    }

    /**
     * Tests the <code>setCreatedAt()</code> and <code>getCreatedAt()</code> methods.
     *
     * @covers Bc\Bundle\UserBundle\Entity\InviteRequest::setCreatedAt()
     * @covers Bc\Bundle\UserBundle\Entity\InviteRequest::getCreatedAt()
     */
    public function testSetCreatedAt_GetCreatedAt()
    {
        $date = new \DateTime();
        $this->inviteRequest->setCreatedAt($date);
        $this->assertEquals($date, $this->inviteRequest->getCreatedAt());
    }

    /**
     * Tests the <code>setUpdatedAt()</code> and <code>getUpdatedAt()</code> methods.
     *
     * @covers Bc\Bundle\UserBundle\Entity\InviteRequest::setUpdatedAt()
     * @covers Bc\Bundle\UserBundle\Entity\InviteRequest::getUpdatedAt()
     */
    public function testSetUpdatedAt_GetUpdatedAt()
    {
        $date = new \DateTime();
        $this->inviteRequest->setUpdatedAt($date);
        $this->assertEquals($date, $this->inviteRequest->getUpdatedAt());
    }
}
