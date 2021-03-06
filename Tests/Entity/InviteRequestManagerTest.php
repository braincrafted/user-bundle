<?php
/**
 * This file is part of BraincraftedUserBundle.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Braincrafted\Bundle\UserBundle\Tests\Entity;

use \Mockery as m;

use Braincrafted\Bundle\UserBundle\Entity\InviteRequestManager;
use Braincrafted\Bundle\UserBundle\Entity\InviteRequest;

/**
 * InviteRequestManagerTest
 *
 * @category    Tests
 * @package     BraincraftedUserBundle
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
    private $class = '\Braincrafted\Bundle\UserBundle\Tests\Entity\MockInviteRequest';

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
     * @covers Braincrafted\Bundle\UserBundle\Entity\InviteRequestManager::__construct()
     * @covers Braincrafted\Bundle\UserBundle\Entity\InviteRequestManager::createInviteRequest()
     */
    public function testCreateInviteRequest()
    {
        $this->assertInstanceOf($this->class, $this->manager->createInviteRequest());
    }

    /**
     * Tests the <code>findInviteRequests()</code> method.
     *
     * @covers Braincrafted\Bundle\UserBundle\Entity\InviteRequestManager::__construct()
     * @covers Braincrafted\Bundle\UserBundle\Entity\InviteRequestManager::findInviteRequests()
     */
    public function testFindInviteRequests()
    {
        $entities = array(m::mock($this->class));

        $this->repository
            ->shouldReceive('findBy')
            ->with(array('deletedAt' => null))
            ->once()
            ->andReturn($entities);

        $this->assertEquals($entities, $this->manager->findInviteRequests());
    }

    /**
     * Tests the <code>updateInviteRequest()</code> method.
     *
     * @covers Braincrafted\Bundle\UserBundle\Entity\InviteRequestManager::__construct()
     * @covers Braincrafted\Bundle\UserBundle\Entity\InviteRequestManager::updateInviteRequest()
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
     * @covers Braincrafted\Bundle\UserBundle\Entity\InviteRequestManager::__construct()
     * @covers Braincrafted\Bundle\UserBundle\Entity\InviteRequestManager::updateInviteRequest()
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
     * @covers Braincrafted\Bundle\UserBundle\Entity\InviteRequestManager::__construct()
     * @covers Braincrafted\Bundle\UserBundle\Entity\InviteRequestManager::flush()
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
