<?php
/**
 * This file is part of BcUserBundle.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserBundle\Tests\Entity;

use \Mockery as m;

use Bc\Bundle\UserBundle\Entity\InviteRequestManager;
use Bc\Bundle\UserBundle\Entity\InviteRequest;

/**
 * InviteRequestManagerTest
 *
 * @category    Tests
 * @package     BcUserBundle
 * @subpackage  Entity
 * @author      Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright   2013 Florian Eckerstorfer
 * @license     http://opensource.org/licenses/MIT The MIT License
 * @group       unit
 */
class InviteRequestManagerTest extends \PHPUnit_Framework_TestCase
{
    /** @var InviteRequestManager */
    private $manager;

    /** @var \Doctrine\Common\Persistence\ObjectManager */
    private $om;

    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $repository;

    /** @var string */
    private $class = '\Bc\Bundle\UserBundle\Tests\Entity\MockInviteRequest';

    public function setUp()
    {
        $this->repository = m::mock('Doctrine\Common\Persistence\ObjectRepository');

        $metadata = m::mock('Doctrine\Common\Persistence\Mapping\ClassMetadata');
        $metadata
            ->shouldReceive('getName')
            ->withNoArgs()
            ->once()
            ->andReturn($this->class);

        $this->om = m::mock('Doctrine\Common\Persistence\ObjectManager');
        $this->om
            ->shouldReceive('getRepository')
            ->with($this->class)
            ->once()
            ->andReturn($this->repository);
        $this->om
            ->shouldReceive('getClassMetadata')
            ->with($this->class)
            ->once()
            ->andReturn($metadata);

        $this->manager = new InviteRequestManager($this->om, $this->class);
    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * Tests the <code>createInviteRequest()</code> method.
     *
     * @covers Bc\Bundle\UserBundle\Entity\InviteRequestManager::__construct()
     * @covers Bc\Bundle\UserBundle\Entity\InviteRequestManager::createInviteRequest()
     */
    public function testCreateInviteRequest()
    {
        $this->assertInstanceOf($this->class, $this->manager->createInviteRequest());
    }

    /**
     * Tests the <code>findInviteRequests()</code> method.
     *
     * @covers Bc\Bundle\UserBundle\Entity\InviteRequestManager::__construct()
     * @covers Bc\Bundle\UserBundle\Entity\InviteRequestManager::findInviteRequests()
     */
    public function testFindInviteRequests()
    {
        $entities = array(m::mock($this->class));

        $this->repository
            ->shouldReceive('findAll')
            ->withNoArgs()
            ->once()
            ->andReturn($entities);

        $this->assertEquals($entities, $this->manager->findInviteRequests());
    }

    /**
     * Tests the <code>updateInviteRequest()</code> method.
     *
     * @covers Bc\Bundle\UserBundle\Entity\InviteRequestManager::__construct()
     * @covers Bc\Bundle\UserBundle\Entity\InviteRequestManager::updateInviteRequest()
     */
    public function testUpdateInviteRequest()
    {
        $entity = m::mock($this->class);
        $entity
            ->shouldReceive('setUpdatedAt')
            ->with(m::any())
            ->once();

        $this->om
            ->shouldReceive('persist')
            ->with($entity)
            ->once();
        $this->om
            ->shouldReceive('flush')
            ->withNoArgs()
            ->once();

        $this->manager->updateInviteRequest($entity, true);
    }

    /**
     * Tests the <code>updateInviteRequest()</code> method with <code>$flush = false</code>.
     *
     * @covers Bc\Bundle\UserBundle\Entity\InviteRequestManager::__construct()
     * @covers Bc\Bundle\UserBundle\Entity\InviteRequestManager::updateInviteRequest()
     */
    public function testUpdateInviteRequest_NoFlush()
    {
        $entity = m::mock($this->class);
        $entity
            ->shouldReceive('setUpdatedAt')
            ->with(m::any())
            ->once();

        $this->om
            ->shouldReceive('persist')
            ->with($entity)
            ->once();
        $this->om
            ->shouldReceive('flush')
            ->withNoArgs()
            ->never();

        $this->manager->updateInviteRequest($entity, false);
    }

    /**
     * Tests the <code>flush()</code> method.
     *
     * @covers Bc\Bundle\UserBundle\Entity\InviteRequestManager::__construct()
     * @covers Bc\Bundle\UserBundle\Entity\InviteRequestManager::flush()
     */
    public function testFlush()
    {
        $this->om
            ->shouldReceive('flush')
            ->withNoArgs()
            ->once();

        $this->manager->flush();
    }
}

class MockInviteRequest extends InviteRequest
{
}
