<?php


namespace MapUx\Builder;


use MapUx\Model\Map;

interface MapBuilderInterface
{
    public function createMap(float $latitude, float $longitude, int $zoomLevel): Map;
}
