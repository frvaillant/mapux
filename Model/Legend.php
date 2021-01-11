<?php


namespace MapUx\Model;

use MapUx\Model\Map;
use MapUx\Model\Marker;
use MapUx\Services\ColorConverterTrait;

class Legend
{

    use ColorConverterTrait;


    public function __construct(Map $map)
    {
        $this->map = $map;
    }

    private function getMarkers()
    {
        $legendMarkers = [];
        $markers = $this->map->getAllMarkers();

        foreach ($markers as $marker) {
            if (!in_array($marker->getIconObject()->getIconPicture(), $legendMarkers) && $marker->getLegendName()) {
                $legendMarkers[$marker->getIconObject()->getIconPicture()] = $marker->getLegendName();
            }
        }
        return $legendMarkers;
    }

    private function getLayers()
    {
        $legendLayers = [];
        $layers = $this->map->getLayers();
        foreach ($layers as $layer) {
            if($layer instanceof ShapeLayer && $layer->getLegendName()) {
                $legendLayers[] = [
                    'type'  => $layer->getLegendType(),
                    'title' => $layer->getLegendName(),
                    'style' => [
                        'background' => $this->hex2rgba($layer->getFillColor(), $layer->getFillOpacity()),
                        'border'     => $layer->getWeight() . 'px solid ' . $this->hex2rgba($layer->getColor(), $layer->getOpacity()),
                    ]
                ];
            }
        }
        return $legendLayers;
    }

    public function getHtml($classes = "")
    {
        $html = '<div class="mapux-legend ' . $classes . ' ' . $this->map->getLegendPosition() .'">';
        $html .= '<span class="mapux-legend-title">' . $this->map->getTitle() . '</span>';

        $markers = $this->getMarkers();
        foreach ($markers as $picture => $title) {
            $html .= '<div class="mapux-legend-element">';
            $html .= '<span class="mapux-legend-img"><img src="' . $picture . '" alt="' . htmlspecialchars_decode($title) . '"></span>';
            $html .= '<span class="mapux-legend-text">' . htmlspecialchars_decode($title) . '</span>';
            $html .= '</div>';
        }

        $layers = $this->getLayers();

        foreach ($layers as $layer) {
            $html .= '<div class="mapux-legend-element">';
            $html .= '<span class="mapux-legend-img"><div class="mapux-legend-' . $layer['type'] . '" style="';
            foreach ($layer['style'] as $name => $value) {
                $html .= $name . ': ' . $value . '; ';
            }
            $html .= '"></div></span> <span class="mapux-legend-text">' . htmlspecialchars_decode($layer['title']) . '</span>';
            $html .= '</div>';
        }
        $html .= '</div>';

        return $html;
    }

}
