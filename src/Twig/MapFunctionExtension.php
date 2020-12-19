<?php


namespace MapUx\Twig;


use MapUx\Model\Map;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class MapFunctionExtension extends AbstractExtension
{
    public function __construct()
    {
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('render_map', [$this, 'renderMap'], ['is_safe' => ['html']]),
        ];
    }

    public function renderMap(string $mapId, Map $map)
    {
        if ($map->isReady()) {
            return '<div class="ux-map" id="' . $mapId . '" 
                        data-lat="' . $map->getCenterLatitude() . '" 
                        data-lon="' . $map->getCenterLongitude() . '"
                        data-zoom="' . $map->getZoomLevel() . '">
                    </div>';
        }
    }
}
