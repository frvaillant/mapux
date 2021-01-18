<?php


namespace MapUx\tests\Model;


use MapUx\Model\Icon;
use MapUx\Model\Map;
use MapUx\Model\Marker;
use PHPUnit\Framework\TestCase;

class IconTest extends TestCase
{

    public function testInstances()
    {
        $icon = new Icon();
        $this->assertEquals(true, $icon instanceof Icon);
    }

    public function testInstanceFromMarker()
    {
        $marker = new Marker();
        $this->assertEquals(true, $marker->getIconObject() instanceof Icon);
    }

    public function testRender()
    {
        $icon = new Icon();
        $expected = json_encode([
            'iconUrl'       => '/bundle/mapux/images/marker-icon.png',
            'shadowUrl'     => '/bundle/mapux/images/marker-shadow.png',
            'iconSize'      => [25, 41],
            'iconAnchor'    => [12, 41],
            'popupAnchor'   => [1, -34],
            'tooltipAnchor' => [16, -28],
            'shadowSize'    => [41, 41],
            'className'     => ''
        ]);
        $this->assertEquals($expected, $icon->render());
    }
}
