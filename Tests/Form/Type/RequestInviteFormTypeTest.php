<?php
/**
 * This file is part of BraincraftedUserBundle.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Braincrafted\Bundle\UserBundle\Tests\Form\Type;

use \Mockery as m;

use Braincrafted\Bundle\UserBundle\Form\Type\RequestInviteFormType;

/**
 * RequestInviteFormTypeTest
 *
 * @category    Tests
 * @package     BraincraftedUserBundle
 * @subpackage  FormType
 * @author      Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright   2013 Florian Eckerstorfer
 * @license     http://opensource.org/licenses/MIT The MIT License
 * @group       unit
 */
class RequestInviteFormTypeTest extends \PHPUnit_Framework_TestCase
{
    /** @var RequestInviteFormType */
    private $type;

    public function setUp()
    {
        $this->type = new RequestInviteFormType('stdClass');
    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * Tests the <code>buildForm()</code> method.
     *
     * @covers Braincrafted\Bundle\UserBundle\Form\Type\RequestInviteFormType::buildForm()
     */
    public function testBuildForm()
    {
        $builder = m::mock('Symfony\Component\Form\FormBuilderInterface');
        $builder
            ->shouldReceive('add')
            ->with('email', 'email')
            ->once();

        $this->type->buildForm($builder, array());
    }

    /**
     * Tests the <code>setDefaultOptions()</code> method.
     *
     * @covers Braincrafted\Bundle\UserBundle\Form\Type\RequestInviteFormType::__construct()
     * @covers Braincrafted\Bundle\UserBundle\Form\Type\RequestInviteFormType::setDefaultOptions()
     */
    public function testSetDefaultOptions()
    {
        $resolver = m::mock('Symfony\Component\OptionsResolver\OptionsResolverInterface');
        $resolver
            ->shouldReceive('setDefaults')
            ->with(array('data_class' => 'stdClass', 'intention' => 'request_invite'))
            ->once();

        $this->type->setDefaultOptions($resolver);
    }

    /**
     * Tests the <code>getName()</code> method.
     *
     * @covers Braincrafted\Bundle\UserBundle\Form\Type\RequestInviteFormType::getName()
     */
    public function testGetName()
    {
        $this->assertEquals('braincrafted_request_invite', $this->type->getName());
    }
}
