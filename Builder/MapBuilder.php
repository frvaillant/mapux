<?php


namespace MapUx\Builder;


use MapUx\Builder\MapBuilderInterface;
use MapUx\Command\ProjectDirProvider;
use MapUx\Model\Map;


class MapBuilder implements MapBuilderInterface
{

    public function createMap(float $latitude = Map::DEFAULT_LAT, float $longitude = Map::DEFAULT_LON, int $zoomLevel = Map::DEFAULT_ZOOM, string $background = null): Map
    {
        return new Map($latitude, $longitude, $zoomLevel, $background);
    }

}
