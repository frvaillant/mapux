<?php


namespace MapUx\tests\Services;


use MapUx\Services\GeoServicesTrait;
use PHPUnit\Framework\TestCase;

class DistanceCalculatorTest extends TestCase
{
    use GeoServicesTrait;

    public function testDistance()
    {
        $d = $this->distanceBetween(44, 1, 42, 2);
        $this->assertEquals( 236787.13, $d);
    }
}
