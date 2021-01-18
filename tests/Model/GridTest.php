<?php


namespace MapUx\tests\Model;


use MapUx\Model\Layer;
use PHPUnit\Framework\TestCase;
use MapUx\Model\Grid;

class GridTest extends TestCase
{
    public function testPointsOrder()
    {
        try {
            $grid = new Grid([44, 1], [42, 2], 10000);
        } catch(\Exception $e) {
            $this->assertEquals('StartPoint have to be S-O point and endPoint N-E point of grid', $e->getMessage());

        }
    }

    public function testCornerPoints()
    {
        try {
            $grid = new Grid(44, 42, 2, 10000);
        } catch(\Exception $e) {
            $this->assertEquals('startpoint and endpoint of grid have to be defined as array [lat, lng]', $e->getMessage());

        }
    }

    public function testInstancesOf()
    {
         $grid = new Grid([42, 1], [43, 2], 10000);

          $this->assertEquals(true, $grid instanceof Grid);

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
