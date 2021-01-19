<?php

namespace MapUx\tests;

use MapUx\Model\Map;
use MapUx\Model\Marker;
use MapUx\Model\Rectangle;
use MapUx\Model\Circle;
use PHPUnit\Framework\TestCase;
use MapUx\Model\Layer;


class MapTest extends TestCase
{

    public function testMap()
    {
        $map = new Map(44, 2, 10);
        $this->assertInstanceOf(Map::class, $map);
    }

    public function testGetCenterLatitude()
    {
        $map = new Map(44, 2, 10);
        $this->assertEquals(44.0, $map->getCenterLatitude());
    }

    public function testGetCenterLongitude()
    {
        $map = new Map(44, 2, 10);
        $this->assertEquals(2.0, $map->getCenterLongitude());
    }

    public function testGetZoomLevel()
    {
        $map = new Map(44, 2, 10);
        $this->assertEquals(10, $map->getZoomLevel());
    }

    public function testGetBackground()
    {
        $map = new Map(44, 2, 10);
        $this->assertEquals(Layer::DEFAULT_BACKGROUND, $map->getLayers()[0]->getBackground());
    }

    public function testLayersRectangle()
    {
        $map = new Map(44, 2, 10);
        $rectangle = new Rectangle([44,1], [42,0]);
        $map->addLayer($rectangle);
        $expected = '{"1":{"background":"","options":{"color":"#0d47a1","weight":2,"opacity":1,"fillColor":"#2196f3","fillOpacity":0.5},"isGeoJson":false,"events":null,"isRectangle":true,"points":[[44,1],[42,0]]}}';
        $this->assertEquals($expected, $map->getLayersInfos());
        $this->assertEquals(true, is_array(json_decode($expected, true)));
    }


    public function testLayersCircle()
    {
        $map = new Map(44.00, 2.00, 10);
        $circle = new Circle(44, 1, 10000);
        $map->addLayer($circle);
        $expected = '{"1":{"background":"","options":{"radius":10000,"color":"#0d47a1","weight":2,"opacity":1,"fillColor":"#2196f3","fillOpacity":0.5},"isGeoJson":false,"events":null,"isCircle":true,"center":[44,1]}}';
        $this->assertEquals($expected, $map->getLayersInfos());
        $this->assertEquals(true, is_array(json_decode($expected, true)));
    }


}
