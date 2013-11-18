<?php
/**
 * This file is part of BraincraftedUserBundle.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Braincrafted\Bundle\UserBundle\Tests\Entity;

use Braincrafted\Bundle\UserBundle\Entity\InviteRequest;

/**
 * InviteRequestTest
 *
 * @category    Tests
 * @package     BraincraftedUserBundle
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
     * @covers Braincrafted\Bundle\UserBundle\Entity\InviteRequest::__construct()
     */
    public function testConstructor()
    {
        $inviteRequest = new InviteRequest();
        $now = new \DateTime();
        $this->assertEquals($now->format('Y-m-d H:i:s'), $inviteRequest->getCreatedAt()->format('Y-m-d H:i:s'));
    }

    /**
     * Tests the <code>setId()</code> and <code>getId()</code> methods.
     *
     * @covers Braincrafted\Bundle\UserBundle\Entity\InviteRequest::setId()
     * @covers Braincrafted\Bundle\UserBundle\Entity\InviteRequest::getId()
     */
    public function testSetId_getId()
    {
        $this->inviteRequest->setId(42);
        $this->assertEquals(42, $this->inviteRequest->getId());
    }

    /**
     * Tests the <code>setEmail()</code> and <code>getEmail()</code> methods.
     *
     * @covers Braincrafted\Bundle\UserBundle\Entity\InviteRequest::setEmail()
     * @covers Braincrafted\Bundle\UserBundle\Entity\InviteRequest::getEmail()
     */
    public function testSetEmail_GetEmail()
    {
        $this->inviteRequest->setEmail('foo@example.com');
        $this->assertEquals('foo@example.com', $this->inviteRequest->getEmail());
    }

    /**
     * Tests the <code>setCreatedAt()</code> and <code>getCreatedAt()</code> methods.
     *
     * @covers Braincrafted\Bundle\UserBundle\Entity\InviteRequest::setCreatedAt()
     * @covers Braincrafted\Bundle\UserBundle\Entity\InviteRequest::getCreatedAt()
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
     * @covers Braincrafted\Bundle\UserBundle\Entity\InviteRequest::setUpdatedAt()
     * @covers Braincrafted\Bundle\UserBundle\Entity\InviteRequest::getUpdatedAt()
     */
    public function testSetUpdatedAt_GetUpdatedAt()
    {
        $date = new \DateTime();
        $this->inviteRequest->setUpdatedAt($date);
        $this->assertEquals($date, $this->inviteRequest->getUpdatedAt());
    }
}
