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
        if($markers) {
            foreach ($markers as $marker) {
                if (!in_array($marker->getIconObject()->getIconPicture(), $legendMarkers) && $marker->getLegendName()) {
                    $legendMarkers[$marker->getIconObject()->getIconPicture()] = $marker->getLegendName();
                }
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
        if ($markers && !empty($markers)) {
            foreach ($markers as $picture => $title) {
                $htmlBuilder
                    ->div([
                        'attributes' => [
                            'class' => 'mapux-legend-element'
                        ]
                    ])
                    ->span([
                        'attributes' => [
                            'class' => ' mapux-legend-img'
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
                            'class' => ' mapux-legend-text'
                        ],
                        'content' => $title
                    ])
                    ->close()
                    ->close();
            }
        }

        $layers = $this->getLayers();
        if ($layers && !empty($layers)) {
            foreach ($layers as $layer) {

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
                            'style' => $this->makeStyle($layer)
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
        }

        if ($items = $this->map->getLegendItems()) {
            foreach ($items as $item) {
                if (!isset($item['type']) || !isset($item['title']) ) {
                    throw new \Exception('Type and Title must be at least defined for additionnal elements in legend');
                }
                if ($item['type'] === 'picture') {
                    $htmlBuilder
                        ->div([
                            'attributes' => [
                                'class' => 'mapux-legend-element'
                            ]
                        ])
                        ->span([
                            'attributes' => [
                                'class' => ' mapux-legend-img'
                            ]
                        ])
                        ->img([
                            'isSingle' => true,
                            'attributes' => [
                                'src' => $item['picture'],
                                'alt' => htmlspecialchars_decode($item['title'])
                            ]
                        ])
                        ->close()
                        ->span([
                            'attributes' => [
                                'class' => ' mapux-legend-text'
                            ],
                            'content' => $item['title']
                        ])
                        ->close()
                        ->close();
                } else {
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
                        ]);
                    if ($item['type'] !== 'text') {
                        $htmlBuilder->div([
                            'attributes' => [
                                'class' => 'mapux-legend-' . $item['type'],
                                'style' => $this->makeAdditionalElementStyle($item)
                            ]
                        ])
                            ->close();
                    }

                        $htmlBuilder->close()
                        ->span([
                            'attributes' => [
                                'class' => 'mapux-legend-text',
                                'style' => $item['type'] === 'text' ? 'color:' . $this->getItemColor($item) . ';' : ''
                            ],
                            'content' => $item['title']
                        ])
                        ->close()
                        ->close();
                }

            }
        }
        $htmlBuilder->close();
    }

    private function getItemColor($item): string
    {
        return $item['color'] ?? '#000';
    }

    private function makeAdditionalElementStyle($item): string
    {
        $fillColor = $item['fillColor'] ?? '#000';
        $fillOpacity = $item['fillOpacity'] ?? 0.5;
        $color = $item['color'] ?? '#000';
        $opacity = $item['opacity'] ?? 1;
        $weight = $item['weight'] ?? 1;
        $style ='background:' . $this->hex2rgba($fillColor, $fillOpacity) . '; ';
        $style .= $item['type'] === 'line' ? 'border:none' : 'border:' . $weight . 'px solid ' . $this->hex2rgba($color, $opacity) . '; ';
        if($item['type'] === 'line') {
            $style .= 'border-bottom:' . $weight . 'px solid ' . $this->hex2rgba($color, $opacity) . '; ';
        }
        return $style;

    }
    private function makeStyle($layer) {
        $style = '';
        foreach ($layer['style'] as $name => $value) {
            $style .= $name . ': ' . $value . '; ';
        }

        if($layer['type'] === 'line') {
            $style = str_replace('border', 'border-bottom', $style);
        }
        return $style;
    }

}
