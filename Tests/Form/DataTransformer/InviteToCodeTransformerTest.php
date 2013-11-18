<?php
/**
 * This file is part of BraincraftedUserBundle.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Braincrafted\Bundle\UserBundle\Tests\Form\DataTransformer;

use \Mockery as m;

use Braincrafted\Bundle\UserBundle\Form\DataTransformer\InviteToCodeTransformer;

/**
 * InviteToCodeTransformerTest
 *
 * @category    Tests
 * @package     BraincraftedUserBundle
 * @subpackage  DataTransformer
 * @author      Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright   2013 Florian Eckerstorfer
 * @license     http://opensource.org/licenses/MIT The MIT License
 * @group       unit
 */
class InviteToCodeTransformerTest extends \PHPUnit_Framework_TestCase
{
    /** @var InviteToCodeTransformer */
    private $transformer;

    /** @var Doctrine\Common\Persistence\ObjectManager */
    private $om;

    public function setUp()
    {
        $this->om = m::mock('Doctrine\Common\Persistence\ObjectManager');
        $this->transformer = new InviteToCodeTransformer($this->om);
    }

    /**
     * Tests the <code>transform()</code> method.
     *
     * @covers Braincrafted\Bundle\UserBundle\Form\DataTransformer\InviteToCodeTransformer::transform()
     */
    public function testTransform()
    {
        $invite = m::mock('Braincrafted\Bundle\UserBundle\Entity\Invite');
        $invite
            ->shouldReceive('getCode')
            ->withNoArgs()
            ->once()
            ->andReturn('abcdef');

        $this->assertEquals('abcdef', $this->transformer->transform($invite));
    }

    /**
     * Tests the <code>transform()</code> method with <code>$value = NULL</code>.
     *
     * @covers Braincrafted\Bundle\UserBundle\Form\DataTransformer\InviteToCodeTransformer::transform()
     */
    public function testTransform_null()
    {
        $this->assertNull($this->transformer->transform(null));
    }

    /**
     * Tests the <code>transform()</code> method with an invalid value.
     *
     * @covers Braincrafted\Bundle\UserBundle\Form\DataTransformer\InviteToCodeTransformer::transform()
     * @expectedException \Symfony\Component\Form\Exception\UnexpectedTypeException
     */
    public function testTransform_invalid()
    {
        $this->transformer->transform('invalid');
    }

    /**
     * Tests the <code>reverseTransform()</code> method.
     *
     * @covers Braincrafted\Bundle\UserBundle\Form\DataTransformer\InviteToCodeTransformer::__construct()
     * @covers Braincrafted\Bundle\UserBundle\Form\DataTransformer\InviteToCodeTransformer::reverseTransform()
     */
    public function testReverseTransform()
    {
        $invite = m::mock('Braincrafted\Bundle\UserBundle\Entity\Invite');

        $repository = m::mock('Doctrine\Common\Persistence\ObjectRepository');
        $repository
            ->shouldReceive('findOneBy')
            ->with(array('code' => 'abcdef'))
            ->once()
            ->andReturn($invite);

        $this->om
            ->shouldReceive('getRepository')
            ->with('Braincrafted\Bundle\UserBundle\Entity\Invite')
            ->once()
            ->andReturn($repository);

        $this->assertEquals($invite, $this->transformer->reverseTransform('abcdef'));
    }

    /**
     * Tests the <code>reverseTransform()</code> method with <code>$value = NULL</code>.
     *
     * @covers Braincrafted\Bundle\UserBundle\Form\DataTransformer\InviteToCodeTransformer::reverseTransform()
     */
    public function testReverseTransform_null()
    {
        $this->assertNull($this->transformer->reverseTransform(null));
        $this->assertNull($this->transformer->reverseTransform(''));
    }

    /**
     * Tests the <code>reverseTransform()</code> method with an invalid value.
     *
     * @covers Braincrafted\Bundle\UserBundle\Form\DataTransformer\InviteToCodeTransformer::reverseTransform()
     * @expectedException \Symfony\Component\Form\Exception\UnexpectedTypeException
     */
    public function testReverseTransform_invalid()
    {
        $this->transformer->reverseTransform(44);
    }
}
