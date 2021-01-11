<?php


namespace MapUx\Model;

use MapUx\Model\Map;
use MapUx\Model\Marker;
use MapUx\Services\ColorConverterTrait;
use MapUx\Services\HtmlBuilder\HtmlBuilder;

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

    public function getHtml($classes = "", HtmlBuilder $htmlBuilder)
    {
        $htmlBuilder
            ->div([
                'attributes' => [
                    'class' => 'mapux-legend ' . $classes . ' ' . $this->map->getLegendPosition(),
                ]
            ])
                ->span([
                    'attributes' => [
                        'class' => 'mapux-legend-title'
                    ],
                    'content' => $this->map->getTitle()
                ])->close();

        $markers = $this->getMarkers();
        foreach ($markers as $picture => $title) {
            $htmlBuilder
                ->div([
                    'attributes' => [
                        'class' => 'mapux-legend-element'
                    ]
                ])
                    ->span([
                        'attributes' => [
                            'class' =>' mapux-legend-img'
                        ]
                    ])
                        ->img([
                            'isSingle' => true,
                            'attributes' => [
                                'src' => $picture,
                                'alt' => htmlspecialchars_decode($title)
                            ]
                        ])
                    ->close()
                    ->span([
                        'attributes' => [
                            'class' =>' mapux-legend-text'
                        ],
                        'content' => $title
                    ])
                    ->close()
                ->close();
        }

        $layers = $this->getLayers();

        foreach ($layers as $layer) {
            $style = '';
            foreach ($layer['style'] as $name => $value) {
                $style .= $name . ': ' . $value . '; ';
            }
            
            $htmlBuilder
                ->div([
                    'attributes' => [
                        'class' => 'mapux-legend-element'
                    ]
                ])
                    ->span([
                        'attributes' => [
                            'class' => 'mapux-legend-img'
                        ]
                    ])
                        ->div([
                            'attributes' => [
                                'class' => 'mapux-legend-' . $layer['type'],
                                'style' => $style
                            ]
                        ])
                        ->close()
                    ->close()
                ->span([
                    'attributes' => [
                        'class' => 'mapux-legend-text',
                    ],
                    'content' => $layer['title']
                ])
                ->close()
            ->close();
        }
        $htmlBuilder->close();
    }

}
