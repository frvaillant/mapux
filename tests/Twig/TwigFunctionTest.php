<?php


namespace MapUx\tests\Twig;


use MapUx\Builder\MapBuilder;
use MapUx\Model\Circle;
use MapUx\Model\Marker;
use MapUx\Model\Popup;
use MapUx\Twig\MapFunctionExtension;
use PHPUnit\Framework\TestCase;

class TwigFunctionTest extends TestCase
{

    public function testTwigRenderFunction()
    {
        $renderer = new MapFunctionExtension();
        $mapBuilder = new MapBuilder();
        $map = $mapBuilder->createMap();
        $marker = new Marker();
        $marker->setLegendName('the marker title');
        $popup = new Popup('my popup content');
        $marker->addPopup($popup);
        $marker->addEvent('click', 'alert();');
        $map->addMarker($marker);
        $circle = new Circle(44, 1, 10000);
        $map->addLayer($circle);
        $map->setTitle('Title of the map');
        $map->addLegend();

        $expected = stripslashes('<div class="mapux-container"><div class="mapux-map " id="map-id" data-lat="44.848513826112" data-lon="-0.56393444538116" data-zoom="10" data-background="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png" data-options="{&quot;scale&quot;:true}" data-events="" data-markers="[{&quot;lat&quot;:44.8485138261124,&quot;lon&quot;:-0.563934445381165,&quot;icon&quot;:&quot;{\&quot;iconUrl\&quot;:\&quot;\\\/bundle\\\/mapux\\\/images\\\/marker-icon.png\&quot;,\&quot;shadowUrl\&quot;:\&quot;\\\/bundle\\\/mapux\\\/images\\\/marker-shadow.png\&quot;,\&quot;iconSize\&quot;:[25,41],\&quot;iconAnchor\&quot;:[12,41],\&quot;popupAnchor\&quot;:[1,-34],\&quot;tooltipAnchor\&quot;:[16,-28],\&quot;shadowSize\&quot;:[41,41]}&quot;,&quot;options&quot;:&quot;null&quot;,&quot;popup&quot;:&quot;{\&quot;content\&quot;:\&quot;my popup content\&quot;,\&quot;options\&quot;:[]}&quot;,&quot;events&quot;:&quot;[{\&quot;name\&quot;:\&quot;click\&quot;,\&quot;action\&quot;:\&quot;alert();\&quot;,\&quot;params\&quot;:null}]&quot;}]" data-layers="{&quot;1&quot;:{&quot;background&quot;:&quot;&quot;,&quot;options&quot;:{&quot;radius&quot;:10000,&quot;color&quot;:&quot;#0d47a1&quot;,&quot;weight&quot;:2,&quot;opacity&quot;:1,&quot;fillColor&quot;:&quot;#2196f3&quot;,&quot;fillOpacity&quot;:0.5},&quot;isGeoJson&quot;:false,&quot;events&quot;:null,&quot;isCircle&quot;:true,&quot;center&quot;:[44,1]}}"></div><div class="mapux-legend  top-right"><span class="mapux-legend-title">Title of the map</span></div></div>');

        $this->assertEquals($expected, stripslashes($renderer->renderMap('map-id', $map)));
    }

}
