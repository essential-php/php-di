<?php

namespace Essential\Test\Di\Component;

use PHPUnit\Framework\TestCase;
use Essential\Di\Container;
use stdClass;

/**
 * Class ContainerTest
 *
 * @package Essential\Test\Di
 * @author  Jamil Malek <jamil.malek@gmail.com>
 */
class ContainerTest extends TestCase
{
    /**
     * @var Container
     */
    private $container;

    public function setUp()
    {
        $this->container = new Container();
    }

    public function testConstructorWithEntries()
    {
        $container = new Container(['foo.bar' => stdClass::class]);
        $this->assertTrue($container->has('foo.bar'));
    }

    public function testHasMethodWithNoExistIdentifier()
    {
        $this->assertFalse($this->container->has('foo.bar'));
    }

    /**
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage The id parameter must be of type string, stdClass given
     */
    public function testGetMethodWithObjectIdentifier()
    {
        $this->container->get(new stdClass());
    }

    /**
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage The id parameter must be of type string, array given
     */
    public function testGetMethodWithArrayIdentifier()
    {
        $this->container->get(['foo', 'bar']);
    }

    /**
     * @expectedException        \Essential\Di\Exception\NotFoundException
     * @expectedExceptionMessage "foo.bar" not found
     */
    public function testGetMethodWithNoExistIdentifier()
    {
        $this->container->get('foo.bar');
    }

    /**
     * @expectedException        \Essential\Di\Exception\ResolveFailedException
     * @expectedExceptionMessage Failed to resolve "FooBar"
     */
    public function testGetMethodWithBadClass()
    {
        $this->container->add('foo.bar', 'FooBar', true);
        $this->container->get('foo.bar');
    }

    public function testAddRemoveMethod()
    {
        // Test add method
        $this->assertInstanceOf(Container::class, $this->container->add('foo.bar', stdClass::class));
        $this->assertTrue($this->container->has('foo.bar'));
        $this->assertInstanceOf(stdClass::class, $this->container->get('foo.bar'));

        // Test remove method
        $this->assertInstanceOf(Container::class, $this->container->remove('foo.bar'));
        $this->assertFalse($this->container->has('foo.bar'));
    }

    /**
     * @expectedException        \Essential\Di\Exception\ResolveFailedException
     * @expectedExceptionMessage Failed to resolve "FooBar"
     */
    public function testAddMethodWithBadClass()
    {
        $this->container->add('foo.bar', 'FooBar');
    }
}
