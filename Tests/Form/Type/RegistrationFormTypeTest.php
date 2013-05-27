<?php
/**
 * This file is part of BcUserBundle.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserBundle\Tests\Form\Type;

use \Mockery as m;

use Bc\Bundle\UserBundle\Form\Type\RegistrationFormType;

/**
 * RegistrationFormTypeTest
 *
 * @category    Tests
 * @package     BcUserBundle
 * @subpackage  FormType
 * @author      Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright   2013 Florian Eckerstorfer
 * @license     http://opensource.org/licenses/MIT The MIT License
 * @group       unit
 */
class RegistrationFormTypeTest extends \PHPUnit_Framework_TestCase
{
    /** @var RegistrationFormType */
    private $type;

    public function setUp()
    {
        $this->type = new RegistrationFormType('stdClass');
    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * Tests the <code>buildForm()</code> method.
     *
     * @covers Bc\Bundle\UserBundle\Form\Type\RegistrationFormType::buildForm()
     */
    public function testBuildForm()
    {
        $this->type = new RegistrationFormType('stdClass', false);

        $builder = m::mock('Symfony\Component\Form\FormBuilderInterface');
        $builder->shouldReceive('add')->with('username', m::any(), m::any())->once()->andReturn($builder);
        $builder->shouldReceive('add')->with('email', m::any(), m::any())->once()->andReturn($builder);
        $builder->shouldReceive('add')->with('plainPassword', m::any(), m::any())->andReturn($builder);
        $builder
            ->shouldReceive('add')
            ->with('invite', 'bc_invite')
            ->never();

        $this->type->buildForm($builder, array());
    }

    /**
     * Tests the <code>buildForm()</code> method.
     *
     * @covers Bc\Bundle\UserBundle\Form\Type\RegistrationFormType::buildForm()
     */
    public function testBuildForm_InviteRequired()
    {
        $this->type = new RegistrationFormType('stdClass', true);

        $builder = m::mock('Symfony\Component\Form\FormBuilderInterface');
        $builder->shouldReceive('add')->with('username', m::any(), m::any())->once()->andReturn($builder);
        $builder->shouldReceive('add')->with('email', m::any(), m::any())->once()->andReturn($builder);
        $builder->shouldReceive('add')->with('plainPassword', m::any(), m::any())->andReturn($builder);
        $builder
            ->shouldReceive('add')
            ->with('invite', 'bc_invite')
            ->once();

        $this->type->buildForm($builder, array());
    }

    /**
     * Tests the <code>getName()</code> method.
     *
     * @covers Bc\Bundle\UserBundle\Form\Type\RegistrationFormType::getName()
     */
    public function testGetName()
    {
        $this->assertEquals('bc_user_registration', $this->type->getName());
    }
}
