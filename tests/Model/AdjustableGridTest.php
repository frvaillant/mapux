<?php


namespace MapUx\tests\Model;


use MapUx\Model\AdjustableGrid;
use MapUx\Model\Layer;
use PHPUnit\Framework\TestCase;

class AdjustableGridTest extends TestCase
{

    public function testIsInstances()
    {
        $grid = new AdjustableGrid();
        $this->assertEquals(true, $grid instanceof Layer);
    }

    public function tesDefaultParameters()
    {
        $grid = new AdjustableGrid();
        $this->assertEquals('#000', $grid->getColor());
        $this->assertEquals(2, $grid->getWeight());
        $this->assertEquals('', $grid->getBackground());
    }

}
