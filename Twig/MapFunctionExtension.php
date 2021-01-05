<?php


namespace MapUx\Twig;


use MapUx\Model\Map;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class MapFunctionExtension extends AbstractExtension
{

    public function getFunctions()
    {
        return [
            new TwigFunction('render_map', [$this, 'renderMap'], ['is_safe' => ['html']]),
        ];
    }

    public function renderMap(string $mapId, Map $map, string $classList = ""): string
    {
        if ($map->isReady()) {
            return '<div class="ux-map ' . $classList . '" id="' . $mapId . '" 
                        data-lat="' . $map->getCenterLatitude() . '" 
                        data-lon="' . $map->getCenterLongitude() . '"     
                        data-zoom="' . $map->getZoomLevel() . '"
                        data-background="' . $map->getLayers()[0]->getBackground() . '" 
                        data-options=\'' . $map->getOptions() . '\' 
                        data-events=\'' . $map->getEvents() . '\'
                        data-markers=\'' . $map->getMarkers() . '\'
                        data-layers=\'' . $map->getLayersInfos() . '\' 
                        >
                    </div>';
        }
        return '';
    }
}
