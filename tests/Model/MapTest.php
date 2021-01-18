<?php

namespace MapUx\tests;

use MapUx\Model\Map;
use MapUx\Model\Marker;
use MapUx\Model\Rectangle;
use MapUx\Model\Circle;
use PHPUnit\Framework\TestCase;


class MapTest extends TestCase
{

    public function testMap()
    {
        $map = new \MapUx\Model\Map(44, 2, 10);
        $this->assertInstanceOf(Map::class, $map);
    }

    public function testGetCenterLatitude()
    {
        $map = new \MapUx\Model\Map(44, 2, 10);
        $this->assertEquals(44.0, $map->getCenterLatitude());
    }

    public function testGetCenterLongitude()
    {
        $map = new \MapUx\Model\Map(44, 2, 10);
        $this->assertEquals(2.0, $map->getCenterLongitude());
    }

    public function testGetZoomLevel()
    {
        $map = new \MapUx\Model\Map(44, 2, 10);
        $this->assertEquals(10, $map->getZoomLevel());
    }

    public function testGetBackground()
    {
        $map = new \MapUx\Model\Map(44, 2, 10);
        $this->assertEquals(\MapUx\Model\Layer::DEFAULT_BACKGROUND, $map->getLayers()[0]->getBackground());
    }

    public function testLayersRectangle()
    {
        $map = new \MapUx\Model\Map(44, 2, 10);
        $rectangle = new Rectangle([44,1], [42,0]);
        $map->addLayer($rectangle);
        $expected = '{"1":{"background":"","options":{"color":"#0d47a1","weight":2,"opacity":1,"fillColor":"#2196f3","fillOpacity":0.5},"isGeoJson":false,"events":null,"isRectangle":true,"points":[[44,1],[42,0]]}}';
        $this->assertEquals($expected, $map->getLayersInfos());
        $this->assertEquals(true, is_array(json_decode($expected, true)));
    }


    public function testLayersCircle()
    {
        $map = new \MapUx\Model\Map(44.00, 2.00, 10);
        $circle = new Circle(44, 1, 10000);
        $map->addLayer($circle);
        $expected = '{"1":{"background":"","options":{"radius":10000,"color":"#0d47a1","weight":2,"opacity":1,"fillColor":"#2196f3","fillOpacity":0.5},"isGeoJson":false,"events":null,"isCircle":true,"center":[44,1]}}';
        $this->assertEquals($expected, $map->getLayersInfos());
        $this->assertEquals(true, is_array(json_decode($expected, true)));
    }

    public function testMarker()
    {
        $map = new \MapUx\Model\Map(44.00, 2.00, 10);
        $marker = new Marker();
        $map->addMarker($marker);
        $expected = '[{"lat":44.8485138261124,"lon":-0.563934445381165,"icon":"{"iconUrl":"/bundle/mapux/images/marker-icon.png","shadowUrl":"/bundle/mapux/images/marker-shadow.png","iconSize":[25,41],"iconAnchor":[12,41],"popupAnchor":[1,-34],"tooltipAnchor":[16,-28],"shadowSize":[41,41],"className":""}","options":"null","popup":null,"events":null}]';
        $this->assertEquals(1, count($map->getAllMarkers()));
        $this->assertEquals($expected, stripslashes(stripslashes($map->getMarkers())));
        $this->assertEquals(true, is_array(json_decode($map->getMarkers(), true)));
    }

    public function testGetPointsFromMarkers()
    {
        $map = new \MapUx\Model\Map(44.00, 2.00, 10);
        $marker = new Marker(44, 1);
        $map->addMarker($marker);
        $marker2 = new Marker(44, 2);
        $map->addMarker($marker2);
        $marker3 = new Marker (44, 3);
        $map->addMarker($marker3);

        $excepted = [
            [44, 1],
            [44, 2],
            [44, 3]
        ];

        $this->assertEquals($excepted, $map->getPointsFromMarkers());
    }

}
