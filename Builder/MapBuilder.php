<?php


namespace MapUx\Builder;


use MapUx\Builder\MapBuilderInterface;
use MapUx\Factory\ClassFactory;
use MapUx\Model\IconPictures;
use MapUx\Model\IconsDataProvider;
use MapUx\Model\Map;

class MapBuilder implements MapBuilderInterface
{

    public function __construct()
    {
        $iconsBuilder = new IconsPictureBuilder();
        $pictures = $iconsBuilder->getIconsPicture();

        if (IconsDataProvider::MAPUX_ICONS !== $pictures) {
            $factory = new ClassFactory('MapUx\\Model', 'IconsDataProvider', [
                'MAPUX_ICONS' => $pictures,
            ]);
        }
    }

    public function createMap(float $latitude = Map::DEFAULT_LAT, float $longitude = Map::DEFAULT_LON, int $zoomLevel = Map::DEFAULT_ZOOM, string $background = null): Map
    {
        return new Map($latitude, $longitude, $zoomLevel, $background);
    }
}
