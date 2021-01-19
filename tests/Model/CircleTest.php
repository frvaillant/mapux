<?php


namespace MapUx\tests\Model;


use MapUx\Model\Layer;
use MapUx\Model\ShapeLayer;
use PHPUnit\Framework\TestCase;
use MapUx\Model\Circle;

class CircleTest extends TestCase
{

    public function testInstances()
    {
        $circle = new Circle(44, 2, 12000);
        $this->assertEquals(true, $circle instanceof Layer);
        $this->assertEquals(true, $circle instanceof ShapeLayer);
    }

    public function testDefaultParameters()
    {
        $circle = new Circle(44, 2, 12000);
        $this->assertIsFloat($circle->getCenterLat());
        $this->assertIsFloat($circle->getCenterLng());
        $this->assertIsInt($circle->getRadius());
        $this->assertEquals('#2196f3', $circle->getFillColor());
        $this->assertEquals('#0d47a1', $circle->getColor());
        $this->assertEquals(2, $circle->getWeight());
        $this->assertEquals(1, $circle->getOpacity());
        $this->assertEquals(0.5, $circle->getFillOpacity());
    }


    public function testSurface()
    {
        $circle = new Circle(44, 2, 12000);
        $this->assertEquals(452389342.12, $circle->getSurface());
    }
}
