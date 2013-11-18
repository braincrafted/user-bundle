<?php

namespace Braincrafted\Bundle\UserBundle\Tests\Form\Handler;

use \Mockery as m;

use Braincrafted\Bundle\UserBundle\Form\Handler\RequestInviteFormHandler;

/**
 * RequestInviteFormHandlerTest
 *
 * @group unit
 */
class RequestInviteFormHandlerTest extends \PHPUnit_Framework_TestCase
{
    /** @var RequestInviteFormHandler */
    private $handler;

    /** @var Symfony\Component\Form\FormInterface */
    private $form;

    /** @var Symfony\Component\HttpFoundation\Request */
    private $request;

    /** @var Braincrafted\Bundle\UserBundle\Entity\InviteRequestManager */
    private $manager;

    /** @var Braincrafted\Bundle\UserBundle\Entity\InviteRequest */
    private $invite;

    public function setUp()
    {
        $this->form = m::mock('Symfony\Component\Form\FormInterface');
        $this->request = m::mock('Symfony\Component\HttpFoundation\Request');
        $this->manager = m::mock('Braincrafted\Bundle\UserBundle\Entity\InviteRequestManager');
        $this->invite = m::mock('Braincrafted\Bundle\UserBundle\Entity\InviteRequest');

        $this->manager
            ->shouldReceive('createInviteRequest')
            ->withNoArgs()
            ->once()
            ->andReturn($this->invite);

        $this->form
            ->shouldReceive('setData')
            ->with($this->invite)
            ->once();

        $this->handler = new RequestInviteFormHandler($this->form, $this->request, $this->manager);
    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * Tests the <code>process()</code> method.
     *
     * @covers Braincrafted\Bundle\UserBundle\Form\Handler\RequestInviteFormHandler::__construct()
     * @covers Braincrafted\Bundle\UserBundle\Form\Handler\RequestInviteFormHandler::process()
     * @covers Braincrafted\Bundle\UserBundle\Form\Handler\RequestInviteFormHandler::createInviteRequest()
     * @covers Braincrafted\Bundle\UserBundle\Form\Handler\RequestInviteFormHandler::validate()
     * @covers Braincrafted\Bundle\UserBundle\Form\Handler\RequestInviteFormHandler::onSuccess()
     */
    public function testProcess()
    {
        $this->request
            ->shouldReceive('getMethod')
            ->withNoArgs()
            ->once()
            ->andReturn('POST');

        $this->form
            ->shouldReceive('bind')
            ->with($this->request)
            ->once();

        $this->form
            ->shouldReceive('isValid')
            ->withNoArgs()
            ->once()
            ->andReturn(true);

        $this->manager
            ->shouldReceive('updateInviteRequest')
            ->with($this->invite)
            ->once();

        $this->assertTrue($this->handler->process());
    }

    /**
     * Tests the <code>process()</code> method when the form is invalid.
     *
     * @covers Braincrafted\Bundle\UserBundle\Form\Handler\RequestInviteFormHandler::__construct()
     * @covers Braincrafted\Bundle\UserBundle\Form\Handler\RequestInviteFormHandler::process()
     * @covers Braincrafted\Bundle\UserBundle\Form\Handler\RequestInviteFormHandler::createInviteRequest()
     * @covers Braincrafted\Bundle\UserBundle\Form\Handler\RequestInviteFormHandler::validate()
     */
    public function testProcess_InvalidForm()
    {
        $this->request
            ->shouldReceive('getMethod')
            ->withNoArgs()
            ->once()
            ->andReturn('POST');

        $this->form
            ->shouldReceive('bind')
            ->with($this->request)
            ->once();

        $this->form
            ->shouldReceive('isValid')
            ->withNoArgs()
            ->once()
            ->andReturn(false);

        $this->manager
            ->shouldReceive('updateInviteRequest')
            ->with($this->invite)
            ->never();

        $this->assertFalse($this->handler->process());
    }

    /**
     * Tests the <code>process()</code> method when the request method is not POST.
     *
     * @covers Braincrafted\Bundle\UserBundle\Form\Handler\RequestInviteFormHandler::__construct()
     * @covers Braincrafted\Bundle\UserBundle\Form\Handler\RequestInviteFormHandler::createInviteRequest()
     * @covers Braincrafted\Bundle\UserBundle\Form\Handler\RequestInviteFormHandler::process()
     */
    public function testProcess_InvalidRequestType()
    {
        $this->request
            ->shouldReceive('getMethod')
            ->withNoArgs()
            ->once()
            ->andReturn('GET');

        $this->form
            ->shouldReceive('bind')
            ->with($this->request)
            ->never();

        $this->form
            ->shouldReceive('isValid')
            ->withNoArgs()
            ->never();

        $this->manager
            ->shouldReceive('updateInviteRequest')
            ->with($this->invite)
            ->never();

        $this->assertFalse($this->handler->process());
    }
}
