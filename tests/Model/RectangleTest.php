<?php


namespace MapUx\tests\Model;


use MapUx\Model\Layer;
use MapUx\Model\ShapeLayer;
use PHPUnit\Framework\TestCase;
use MapUx\Model\Rectangle;

class RectangleTest extends TestCase
{

    public function testInstances()
    {
        $rectangle = new Rectangle([44, 1], [42,2]);
        $this->assertEquals(true, $rectangle instanceof Layer);
        $this->assertEquals(true, $rectangle instanceof ShapeLayer);
    }

    public function testDefaultParameters()
    {
        $rectangle = new Rectangle([44, 1], [42,2]);
        $this->assertIsArray($rectangle->getFirstPoint());
        $this->assertIsArray($rectangle->getSecondPoint());
        $this->assertEquals('#2196f3', $rectangle->getFillColor());
        $this->assertEquals('#0d47a1', $rectangle->getColor());
        $this->assertEquals(2, $rectangle->getWeight());
        $this->assertEquals(1, $rectangle->getOpacity());
        $this->assertEquals(0.5, $rectangle->getFillOpacity());
    }

    public function testSurface()
    {
        $rectangle = new Rectangle([44, 1], [42,2]);
        $this->assertEquals(17788174617.53, $rectangle->getSurface());
        $this->assertEquals(17788174617.53, round($rectangle->getLength() * $rectangle->getWidth(), 2));
    }

    public function testGetLength()
    {
        $rectangle = new Rectangle([44, 1], [42,2]);
        $this->assertEquals(222389.85, $rectangle->getLength());
    }

    public function testGetWidth()
    {
        $rectangle = new Rectangle([44, 1], [42,2]);
        $this->assertEquals(79986.45, $rectangle->getWidth());
    }
}
