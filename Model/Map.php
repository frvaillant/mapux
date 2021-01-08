<?php


namespace MapUx\Model;


class Map
{
    const DEFAULT_LAT  = 44.8485138261124;
    const DEFAULT_LON  = -0.563934445381165;
    const DEFAULT_ZOOM = 10;
    /**
     * @var float
     */
    private $centerLatitude;
    /**
     * @var float
     */
    private $centerLongitude;
    /**
     * @var int
     */
    private $zoomLevel;

    /**
     * @var array
     */
    private $layers;

    /**
     * @var array
     */
    private $markers;

    /**
     * @var array
     */
    private $options = [];

    /**
     * @var array
     */
    private $events;

    /**
     * @var bool
     */
    private $showLegend = false;

    /**
     * @var string
     */
    private $title = null;

    /**
     * @var string
     */
    private $legendPosition = 'top-right';

    /**
     * @var bool
     */
    private $hasScale = true;


    public function __construct(
        float $centerLatitude  = self::DEFAULT_LAT,
        float $centerLongitude = self::DEFAULT_LON,
        int $zoomLevel         = self::DEFAULT_ZOOM,
        string $background     = null
    )
    {
        $this->setCenterLatitude($centerLatitude);
        $this->setCenterLongitude($centerLongitude);
        $this->setZoomLevel($zoomLevel);
        $background ? $this->addLayer(new Layer($background)) : $this->addLayer(new Layer());
        $this->options['scale'] = $this->hasScale();
    }

    public function setBackground($background)
    {
        $this->layers[0] = new Layer($background);
    }

    public function removeBackground()
    {
        $this->setBackground('');
    }


    public function isReady()
    {
        return (
            null !== $this->centerLatitude && is_float($this->centerLatitude) &&
            null !== $this->centerLongitude && is_float($this->centerLongitude) &&
            null !== $this->zoomLevel && is_integer($this->zoomLevel)
        );
    }

    /**
     * @param Layer $layer
     */
    public function addLayer(Layer $layer)
    {
        $this->layers[] = $layer;
    }

    /**
     * @return mixed
     */
    public function getLayers(): array
    {
        return $this->layers;
    }

    public function getLayersInfos(): string
    {
        $layers = [];
        $n = 0;
        foreach ($this->layers as $layer) {
            if($n > 0) {
                $layers[$n] = [
                    'background' => $layer->getBackground(),
                    'options'    => $layer->getOptions(),
                    'isGeoJson'  => false,
                    'events'     => $layer->getEvents() ?? null
                ];

                if($layer instanceof GeojsonLayer) {
                    $layers[$n]['isGeoJson'] = true;
                    $layers[$n]['json'] = $layer->getJson();
                    $layers[$n]['options'] = [
                        'fillColor' => $layer->getFillColor(),
                        'color'     => $layer->getColor(),
                        'weight'    => $layer->getWeight(),
                        'opacity'   => $layer->getOpacity(),
                        'fillOpacity' => $layer->getFillOpacity(),
                    ];
                    $layers[$n]['events'] = $layer->getEvents() ?? null;

                    foreach ($layer->getOptions() as $key => $value) {
                        $layers[$n]['options'][$key] = $value;
                    }

                }


                if($layer instanceof Circle) {
                    $layers[$n]['isCircle'] = true;
                    $layers[$n]['center']   = $layer->getCenter();
                    $layers[$n]['options']    = [
                        'radius'      => $layer->getRadius(),
                        'color'       => $layer->getColor(),
                        'weight'      => $layer->getWeight(),
                        'opacity'     => $layer->getOpacity(),
                        'fillColor'   => $layer->getFillColor(),
                        'fillOpacity' => $layer->getFillOpacity(),
                    ];
                    $layers[$n]['events'] = $layer->getEvents() ?? null;
                    foreach ($layer->getOptions() as $key => $value) {
                        $layers[$n]['options'][$key] = $value;
                    }
                }

                if($layer instanceof Rectangle) {
                    $layers[$n]['isRectangle'] = true;
                    $layers[$n]['points']   = [$layer->getFirstPoint(), $layer->getSecondPoint()];
                    $layers[$n]['options']    = [
                        'color'       => $layer->getColor(),
                        'weight'      => $layer->getWeight(),
                        'opacity'     => $layer->getOpacity(),
                        'fillColor'   => $layer->getFillColor(),
                        'fillOpacity' => $layer->getFillOpacity(),
                    ];

                    $layers[$n]['events'] = $layer->getEvents() ?? null;
                    foreach ($layer->getOptions() as $key => $value) {
                        $layers[$n]['options'][$key] = $value;
                    }

                }

                if($layer instanceof Grid) {
                    $layers[$n]['isGrid']  = true;
                    $layers[$n]['options'] =  $layer->getParameters();
                }

                if($layer instanceof AdjustableGrid) {
                    $layers[$n]['isAdjustableGrid']  = true;
                    $layers[$n]['color'] =  $layer->getColor();
                    $layers[$n]['width'] =  $layer->getWeight();
                }
            }
            $n++;
        }
        return json_encode($layers);
    }

    /**
     * @return float
     */
    public function getCenterLatitude(): float
    {
        return $this->centerLatitude;
    }

    /**
     * @param float $centerLatitude
     */
    public function setCenterLatitude(float $centerLatitude): void
    {
        $this->centerLatitude = $centerLatitude;
    }

    /**
     * @return float
     */
    public function getCenterLongitude(): float
    {
        return $this->centerLongitude;
    }

    /**
     * @param float $centerLongitude
     */
    public function setCenterLongitude(float $centerLongitude): void
    {
        $this->centerLongitude = $centerLongitude;
    }

    /**
     * @return int
     */
    public function getZoomLevel(): int
    {
        return $this->zoomLevel;
    }

    /**
     * @param int $zoomLevel
     */
    public function setZoomLevel(int $zoomLevel): void
    {
        $this->zoomLevel = $zoomLevel;
    }

    public function addMarker(Marker $marker)
    {
        $this->markers[] = $marker;
    }

    public function setMarkers(array $markers)
    {
        $this->markers = $markers;
    }

    public function getMarkers()
    {
        $markers = [];
        if ($this->markers) {
            foreach ($this->markers as $marker) {
                $markers[] = [
                    'lat'     => $marker->getLatitude(),
                    'lon'     => $marker->getLongitude(),
                    'icon'    => $marker->getIcon(),
                    'options' => $marker->getOptions(),
                    'popup'   => $marker->getPopup(),
                    'events'  => $marker->getEvents()
                ];
            }
        }
        return json_encode($markers);
    }

    public function getAllMarkers()
    {
        return $this->markers;
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    public function getOptions()
    {
        return json_encode($this->options);
    }

    public function addEvent(string $eventName, $action, $params = null)
    {
        $this->events[$eventName] = [$action, $params];
    }

    /**
     * @return array
     */
    public function getEvents(): ?string
    {
        if ($this->events) {
            $events = [];
            foreach ($this->events as $name => [$action, $params]) {
                $events[] = [
                    'name'   => $name,
                    'action' => $action,
                    'params' => $params ?? null,
                ];
            }
            return json_encode($events);
        }
        return null;
    }

    /**
     * @param array $events
     */
    public function setEvents(array $events): void
    {
        $this->events = $events;
    }

    public function getPointsFromMarkers(): array
    {
        $points = [];
        foreach ($this->markers as $marker) {
            $points[] = [$marker->getLatitude(), $marker->getLongitude()];
        }
        return $points;
    }

    public function addLegend($position = '')
    {
        $this->showLegend = true;
        $this->legendPosition = $position;
    }

    public function hasLegend()
    {
        return $this->showLegend;
    }

    public function getLegend($classes = "")
    {
        //TODO returning html
        $legend = new Legend($this);
        return $legend->getHtml($classes);
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getLegendPosition(): string
    {
        return $this->legendPosition;
    }

    /**
     * @return bool
     */
    public function hasScale(): bool
    {
        return $this->hasScale;
    }

    public function removeScale(): void
    {
        $this->hasScale = false;
        $this->options['scale'] = $this->hasScale();
    }



}
