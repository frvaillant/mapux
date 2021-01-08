<?php


namespace MapUx\Model;

use MapUx\Model\Map;
use MapUx\Model\Marker;

class Legend
{



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
            $html .= '<span class="mapux-legend-img"><img src="' . $picture . '" alt="' . str_replace("`", "'", $title) . '"></span>';
            $html .= '<span class="mapux-legend-text">' . str_replace("`", "'", $title) . '</span>';
            $html .= '</div>';
        }

        $layers = $this->getLayers();

        foreach ($layers as $layer) {
            $html .= '<div class="mapux-legend-element">';
            $html .= '<span class="mapux-legend-img"><div class="mapux-legend-' . $layer['type'] . '" style="';
            foreach ($layer['style'] as $name => $value) {
                $html .= $name . ': ' . $value . '; ';
            }
            $html .= '"></div></span> <span class="mapux-legend-text">' . str_replace("`", "'", $layer['title']) . '</span>';
            $html .= '</div>';
        }
        $html .= '</div>';

        return $html;
    }


    private function hex2rgba($color, $opacity = null) {

        $default = 'rgb(0,0,0)';

        //Return default if no color provided
        if(empty($color))
            return $default;

        //Sanitize $color if "#" is provided
        if ($color[0] == '#' ) {
            $color = substr( $color, 1 );
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
            $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
            $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
            return $default;
        }

        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if($opacity){
            if(abs($opacity) > 1)
                $opacity = 1.0;
            $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
            $output = 'rgb('.implode(",",$rgb).')';
        }

        //Return rgb(a) color string
        return $output;
    }

}
