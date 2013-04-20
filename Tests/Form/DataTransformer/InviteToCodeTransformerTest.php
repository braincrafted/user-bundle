<?php

namespace Bc\Bundle\UserBundle\Tests\Form\DataTransformer;

use \Mockery as m;

use Bc\Bundle\UserBundle\Form\DataTransformer\InviteToCodeTransformer;

/**
 * InviteToCodeTransformerTest
 *
 * @group unit
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
     * @covers Bc\Bundle\UserBundle\Form\DataTransformer\InviteToCodeTransformer::transform()
     */
    public function testTransform()
    {
        $invite = m::mock('Bc\Bundle\UserBundle\Entity\Invite');
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
     * @covers Bc\Bundle\UserBundle\Form\DataTransformer\InviteToCodeTransformer::transform()
     */
    public function testTransform_null()
    {
        $this->assertNull($this->transformer->transform(null));
    }

    /**
     * Tests the <code>transform()</code> method with an invalid value.
     *
     * @covers Bc\Bundle\UserBundle\Form\DataTransformer\InviteToCodeTransformer::transform()
     * @expectedException \Symfony\Component\Form\Exception\UnexpectedTypeException
     */
    public function testTransform_invalid()
    {
        $this->transformer->transform('invalid');
    }

    /**
     * Tests the <code>reverseTransform()</code> method.
     *
     * @covers Bc\Bundle\UserBundle\Form\DataTransformer\InviteToCodeTransformer::__construct()
     * @covers Bc\Bundle\UserBundle\Form\DataTransformer\InviteToCodeTransformer::reverseTransform()
     */
    public function testReverseTransform()
    {
        $invite = m::mock('Bc\Bundle\UserBundle\Entity\Invite');

        $repository = m::mock('Doctrine\Common\Persistence\ObjectRepository');
        $repository
            ->shouldReceive('findOneBy')
            ->with(array('code' => 'abcdef'))
            ->once()
            ->andReturn($invite);

        $this->om
            ->shouldReceive('getRepository')
            ->with('Bc\Bundle\UserBundle\Entity\Invite')
            ->once()
            ->andReturn($repository);

        $this->assertEquals($invite, $this->transformer->reverseTransform('abcdef'));
    }

    /**
     * Tests the <code>reverseTransform()</code> method with <code>$value = NULL</code>.
     *
     * @covers Bc\Bundle\UserBundle\Form\DataTransformer\InviteToCodeTransformer::reverseTransform()
     */
    public function testReverseTransform_null()
    {
        $this->assertNull($this->transformer->reverseTransform(null));
        $this->assertNull($this->transformer->reverseTransform(''));
    }

    /**
     * Tests the <code>reverseTransform()</code> method with an invalid value.
     *
     * @covers Bc\Bundle\UserBundle\Form\DataTransformer\InviteToCodeTransformer::reverseTransform()
     * @expectedException \Symfony\Component\Form\Exception\UnexpectedTypeException
     */
    public function testReverseTransform_invalid()
    {
        $this->transformer->reverseTransform(44);
    }
}
