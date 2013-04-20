<?php
/**
 * This file is part of BcUserBundle.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserBundle\Tests\Form\Type;

use \Mockery as m;

use Bc\Bundle\UserBundle\Form\Type\InviteFormType;

/**
 * InviteFormTypeTest
 *
 * @category    Tests
 * @package     BcUserBundle
 * @subpackage  FormType
 * @author      Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright   2013 Florian Eckerstorfer
 * @license     http://opensource.org/licenses/MIT The MIT License
 * @group       unit
 */
class InviteFormTypeTest extends \PHPUnit_Framework_TestCase
{
    /** @var InviteFormType */
    private $type;

    /** @var Bc\Bundle\UserBundle\Form\DataTransformer\InviteToCodeTransformer */
    private $transformer;

    public function setUp()
    {
        $this->transformer = m::mock('Bc\Bundle\UserBundle\Form\DataTransformer\InviteToCodeTransformer');
        $this->type = new InviteFormType($this->transformer);
    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * Tests the <code>buildForm()</code> method.
     *
     * @covers Bc\Bundle\UserBundle\Form\Type\InviteFormType::__construct()
     * @covers Bc\Bundle\UserBundle\Form\Type\InviteFormType::buildForm()
     */
    public function testBuildForm()
    {
        $builder = m::mock('Symfony\Component\Form\FormBuilderInterface');
        $builder
            ->shouldReceive('addViewTransformer')
            ->with($this->transformer, true)
            ->once();

        $this->type->buildForm($builder, array());
    }

    /**
     * Tests the <code>setDefaultOptions()</code> method.
     *
     * @covers Bc\Bundle\UserBundle\Form\Type\InviteFormType::setDefaultOptions()
     */
    public function testSetDefaultOptions()
    {
        $resolver = m::mock('Symfony\Component\OptionsResolver\OptionsResolverInterface');
        $resolver
            ->shouldReceive('setDefaults')
            ->with(array('class' => 'Bc\Bundle\UserBundle\Entity\Invite', 'required' => true))
            ->once();

        $this->type->setDefaultOptions($resolver);
    }

    /**
     * Tests the <code>getParent()</code> method.
     *
     * @covers Bc\Bundle\UserBundle\Form\Type\InviteFormType::getParent()
     */
    public function testGetParent()
    {
        $this->assertEquals('text', $this->type->getParent());
    }

    /**
     * Tests the <code>getName()</code> method.
     *
     * @covers Bc\Bundle\UserBundle\Form\Type\InviteFormType::getName()
     */
    public function testGetName()
    {
        $this->assertEquals('bc_invite', $this->type->getName());
    }
}
