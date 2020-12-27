<?php


namespace MapUx\Builder;


use MapUx\Model\Map;
use MapUx\Builder\MapBuilderInterface;


class MapBuilder implements MapBuilderInterface
{
    public function createMap(float $latitude, float $longitude, int $zoomLevel, string $background = null): Map
    {
        return new Map($latitude, $longitude, $zoomLevel, $background);
    }
}
