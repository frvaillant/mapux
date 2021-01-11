<?php


namespace MapUx\tests\Model;


use MapUx\Model\Layer;
use PHPUnit\Framework\TestCase;
use MapUx\Model\Grid;

class GridTest extends TestCase
{

    public function testInstancesOf()
    {
        $grid = new Grid([44,1], [42,2], 10000);
        $this->assertEquals(true, $grid instanceof Layer);
    }

    public function testPoints()
    {
        $grid = new Grid([44,1], [42,2], 10000);
        $this->assertIsArray($grid->getStartPoint());
        $this->assertIsArray($grid->getEndPoint());
    }

    public function testGetParameters()
    {
        $grid = new Grid([44,1], [42,2], 10000);

        $expected = [
            'startLat'    => 44,
            'startLon'    => 1,
            'endLat'      => 42,
            'endLon'      => 2,
            'unit'        => 10000,
            'weight'      => 1,
            'color'       => '#000',
            'fillColor'   => '#2196f3',
            'fillOpacity' => 0.5,
            'opacity'     => 1
        ];

        $this->assertEquals($expected, $grid->getParameters());
    }

}
