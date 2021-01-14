<?php


namespace MapUx\Model;
use MapUx\Model\Popup;
use MapUx\Model\Marker;

/**
 * Class Grid
 * @package MapUx\Model
 */
class Grid extends Layer
{

    /**
     *
     */
    const MIN_CIRCLE_PERCENTAGE = 20;
    /**
     *
     */
    const MAX_CIRCLE_PERCENTAGE = 90;
    /**
     *
     */
    const DEFAULT_CIRCLES_OPTIONS = [
        0 => ['fillColor' => '#000000', 'fillOpacity' => 0.5, 'color' => '#000000', 'opacity' => 1, 'weight' => 2],
        5 => ['fillColor' => '#00FF00', 'fillOpacity' => 0.5, 'color' => '#00FF00', 'opacity' => 1, 'weight' => 2],
        10 => ['fillColor' => '#0000FF', 'fillOpacity' => 0.5, 'color' => '#0000FF', 'opacity' => 1, 'weight' => 2],
        20 => ['fillColor' => '#FF0000', 'fillOpacity' => 0.5, 'color' => '#FF0000', 'opacity' => 1, 'weight' => 2],
    ];
    /**
     * @var string
     */
    protected $color = '#000';

    /**
     * @var string
     */
    protected $fillColor = '#2196f3';

    /**
     * @var integer
     */
    protected $weight = 1;

    /**
     * @var float
     */
    protected $opacity = 1;

    /**
     * @var float
     */
    protected $fillOpacity = 0.5;

    /**
     * @var array
     */
    protected $startPoint;

    /**
     * @var array
     */
    protected $endPoint;

    /**
     * @var integer
     */
    protected $unit;


    /**
     * @var float
     */
    private $startLat = 0.0;

    /**
     * @var float
     */
    private $startLng = 0.0;

    /**
     * @var float
     */
    private $endLat = 0.0;

    /**
     * @var float
     */
    private $endLng = 0.0;

    /**
     * @var array
     */
    private $gridPoints = [];

    /**
     * @var int
     */
    private $countGridLineBoxes = 0;

    /**
     * @var int
     */
    private $countGridColumnsBoxes = 0;

    /**
     * @var bool
     */
    private $stopCountColumns = false;

    /**
     * @var array
     */
    private $markersBox = [];

    /**
     * @var int
     */
    private $lngStep = 0;
    /**
     * @var int
     */
    private $latStep = 0;

    /**
     * Grid constructor.
     * @param $startPoint
     * @param $endPoint
     * @param $unit
     * @throws \Exception
     */
    public function __construct($startPoint, $endPoint, $unit)
    {
        parent::__construct();

        if (!is_array($startPoint) || !is_array($endPoint)) {
            throw new \Exception('startpoint and endpoint of grid have to be defined as array [lat, lng]');
        }
        if ($startPoint[0] > $endPoint[0] || $startPoint[1] > $endPoint[1]) {
            throw new \Exception('StartPoint have to be S-O point and endPoint N-E point of grid');
        }


        $this->removeBackground();
        $this->setStartPoint($startPoint);
        $this->setEndPoint($endPoint);
        $this->setUnit($unit);
        $this->startLat = $this->startPoint[0];
        $this->startLng = $this->startPoint[1];
        $this->endLat = $this->endPoint[0];
        $this->endLng = $this->endPoint[1];
        $this->gridPoints = [];
        $this->countGridLineBoxes = 0;
        $this->countGridColumnsBoxes = 0;
        $this->stopCountColumns = false;
        $this->markersBox = [];
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     */
    public function setWeight(int $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return float
     */
    public function getOpacity(): float
    {
        return $this->opacity;
    }

    /**
     * @param float $opacity
     */
    public function setOpacity(float $opacity): void
    {
        $this->opacity = $opacity;
    }

    /**
     * @return array
     */
    public function getStartPoint(): array
    {
        return $this->startPoint;
    }

    /**
     * @param array $startPoint [$lat, $lng]
     */
    public function setStartPoint(array $startPoint): void
    {
        $this->startPoint = $startPoint;
    }

    /**
     * @return array
     */
    public function getEndPoint(): array
    {
        return $this->endPoint;
    }

    /**
     * @param array $endPoint [$lat, $lng]
     */
    public function setEndPoint(array $endPoint): void
    {
        $this->endPoint = $endPoint;
    }

    /**
     * @return int
     */
    public function getUnit(): int
    {
        return $this->unit;
    }

    /**
     * @param int $unit
     */
    public function setUnit(int $unit): void
    {
        $this->unit = $unit;
    }

    /**
     * @return string
     */
    public function getFillColor(): string
    {
        return $this->fillColor;
    }

    /**
     * @param string $fillColor
     */
    public function setFillColor(string $fillColor): void
    {
        $this->fillColor = $fillColor;
    }

    /**
     * @return float
     */
    public function getFillOpacity(): float
    {
        return $this->fillOpacity;
    }

    /**
     * @param float $fillOpacity
     */
    public function setFillOpacity(float $fillOpacity): void
    {
        $this->fillOpacity = $fillOpacity;
    }


    /**
     * @return array
     */
    public function getParameters(): array
    {
        return [
            'startLat' => $this->getStartPoint()[0],
            'startLon' => $this->getStartPoint()[1],
            'endLat' => $this->getEndPoint()[0],
            'endLon' => $this->getEndPoint()[1],
            'unit' => $this->getUnit(),
            'weight' => $this->getWeight(),
            'color' => $this->getColor(),
            'fillColor' => $this->getFillColor(),
            'fillOpacity' => $this->getFillOpacity(),
            'opacity' => $this->getOpacity()
        ];
    }

    /**
     * @return array
     */
    private function makeGridPoints(): array
    {
        $limit = 0;
        $rowNumber = 1;
        $columnNumber = 1;
        $this->lngStep = $this->getNextLng($this->startLat, $this->startLng) - $this->startLng;
        $this->latStep = $this->getNextLat($this->startLat, $this->startLng) - $this->startLat;

        while ($limit === 0) {

            $this->gridPoints[$rowNumber . ':' . $columnNumber] = [
                'start' => [
                    $this->startLat,
                    $this->startLng
                ],
                'end' => [
                    $this->getNextLat($this->startLat, $this->startLng),
                    $this->getNextLng($this->startLat, $this->startLng),
                ],
                'center' => $this->getGridBoxCenter(
                    $this->startLat,
                    $this->startLng,
                    $this->getNextLat($this->startLat, $this->startLng),
                    $this->getNextLng($this->startLat, $this->startLng),
                    )
            ];
            $this->startLng = $this->getNextLng($this->startLat, $this->startLng);
            if ($this->startLng > $this->endLng) {
                $this->countGridColumnsBoxes = $columnNumber;
                $columnNumber = 1;
                $rowNumber++;
                $this->startLng = $this->startPoint[1];
                $this->startLat = $this->getNextLat($this->startLat, $this->startLng);
                if ($this->startLat > $this->endLat) {
                    $this->countGridLineBoxes = $rowNumber;
                    $limit = 1;
                }
            } else {
                $columnNumber++;
            }
        }
        return $this->gridPoints;
    }

    /**
     * @param $lat0
     * @param $lng0
     * @param $lat1
     * @param $lng1
     * @return array
     */
    private function getGridBoxCenter($lat0, $lng0, $lat1, $lng1): array
    {
        return [$lat0 + ($lat1 - $lat0) / 2, $lng0 + ($lng1 - $lng0) / 2];
    }

    /**
     * @param $lat0
     * @param $lng0
     * @return float
     */
    private function getNextLng($lat0, $lng0): float
    {
        return $lng0 + (180 / M_PI) * ($this->unit / 6371000 * 1.4);
    }

    /**
     * @param $lat0
     * @param $lng0
     * @return float
     */
    private function getNextLat($lat0, $lng0): float
    {
        return $lat0 + (180 / M_PI) * ($this->unit / 6371000);
    }


    /**
     * @param \MapUx\Model\Marker $marker
     * @return string
     */
    private function getMarkerBox(Marker $marker): string
    {
        $numCol = (int)ceil(($marker->getLongitude() - $this->startPoint[1]) / $this->lngStep);
        $numRow = (int)ceil(($marker->getLatitude() - $this->startPoint[0]) /  $this->latStep);
        return $numRow . ':' . $numCol;
    }

    /**
     * @param float $markerLat
     * @param float $markerLng
     * @param string $box
     * @return bool
     */
    private function isMarkerInGoodBox(float $markerLat, float $markerLng, string $box): bool
    {
        return
            $markerLng > $this->gridPoints[$box]['start'][1] &&
            $markerLng < $this->gridPoints[$box]['end'][1] &&
            $markerLat > $this->gridPoints[$box]['start'][0] &&
            $markerLat > $this->gridPoints[$box][end][0];
    }

    /**
     * @param array $markers
     */
    private function makeMarkersGroups(array $markers): void
    {
        foreach ($markers as $marker) {
            $box = $this->getMarkerBox($marker);

            $pop = new Popup($box);
            $marker->addPopup($pop);
            $marker->setLegendName('test');
            if (isset($this->gridPoints[$box])) {
                if (isset($this->markersBox[$box])) {
                    $this->markersBox[$box]['count'] = $this->markersBox[$box]['count'] + 1;
                } else {
                    $this->markersBox[$box] = [
                        'lat' => $this->gridPoints[$box]['center'][0],
                        'lng' => $this->gridPoints[$box]['center'][1],
                        'count' => 1
                    ];
                }
            }
        }
    }

    /**
     * @param $options
     * @param $value
     * @return int|string|null
     */
    private function getOptionsKeyForCircle($options, $value)
    {
        if (isset($options[$value])) {
            return $value;
        }
        if ($value > array_key_last($options)) {
            return array_key_last($options);
        }
        foreach ($options as $key => $value) {
            if ($key >= $value) {
                return $key;
            }
        }
        return 0;
    }

    /**
     * @param $options
     * @param $keyVal
     * @return int|string|null
     */
    private function getNextKey($options, $keyVal)
    {
        foreach ($options as $key => $value) {
            if ($key > $keyVal) {
                return $key;
            }
        }
        return array_key_last($options);
    }

    /**
     * @param $options
     * @param $sizes
     * @param $keyVal
     * @return float|int
     */
    private function getCircleRadius($options, $sizes, $keyVal) {
        $percentage = $sizes[$this->getOptionsKeyForCircle($options, $keyVal)];
        if ($percentage > 1) {
            return ($this->unit / 2) * ($percentage / 100);
        }
        return ($this->unit / 2) * $percentage;
    }

    /**
     * @param $options
     * @return array
     */
    private function makeSizesForCircles($options) {
        $sizes = [];
        $start = self::MIN_CIRCLE_PERCENTAGE;
        $step = (self::MAX_CIRCLE_PERCENTAGE - self::MIN_CIRCLE_PERCENTAGE) / (count($options) - 1);
        $i = 0;
        foreach ($options as $key => $value) {
            $sizes[$key] = $start + ($i * $step);
            $i++;
        }
        return $sizes;
    }

    /**
     * @param Map $map
     * @param array $markers
     * @param bool $legend
     * @param array $options
     * @throws \Exception
     */
    public function addMarkersClusters(Map $map, array $markers, $legend = true, array $options = []): void {

        if (empty($options)) {
            $options = self::DEFAULT_CIRCLES_OPTIONS;
        }

        if (
            !empty($options) &&
            (!isset($options[0]) || count($options) < 2)
        ) {
            throw new \Exception('Your options are not correctly defined. options array must at least have 2 keys and first key must equals to 0');
        }

        $this->makeGridPoints();
        $this->makeMarkersGroups($markers);

        foreach ($this->markersBox as $box) {


            $circle = $this->makeCircle($box, $options);
            $map->addLayer($circle);

            $legendOptions = $this->createLegendOptionsForCircles($options);

        }
        if ($legend) {
            $map->addLegendItems($legendOptions);
        }
    }

    /**
     * @return Circle
     */
    private function makeCircle($box, $options): Circle
    {
        $radius = $this->getCircleRadius($options, $this->makeSizesForCircles($options), $box['count']);

        $circle = new Circle($box['lat'], $box['lng'], $radius);

        $circle->setFillColor($options[$this->getOptionsKeyForCircle($options, $box['count'])]['fillColor'] ?? '#000');
        $circle->setColor($options[$this->getOptionsKeyForCircle($options, $box['count'])]['color'] ?? '#000');
        $circle->setFillOpacity($options[$this->getOptionsKeyForCircle($options, $box['count'])]['fillOpacity'] ?? 0.5);
        $circle->setOpacity($options[$this->getOptionsKeyForCircle($options, $box['count'])]['opacity'] ?? 1);
        $circle->setWeight($options[$this->getOptionsKeyForCircle($options, $box['count'])]['weight'] ?? 0);

        return $circle;
    }

    /**
     * @param $options
     * @return array
     */
    private function createLegendOptionsForCircles($options)
    {
        $legendOptions = [];

        foreach ($options as $key => $option) {

            $title = ($key < array_key_last($options)) ? 'de ' . $key . ' à ' . $this->getNextKey($options, $key) : 'Plus de ' . $key;
            $legendOptions[] = [
                'type' => 'circle',
                'fillColor' => $option['fillColor'] ?? '#000000',
                'color' => $option['color'] ?? '#000000',
                'fillOpacity' => $option['fillOpacity'] ?? 0.5,
                'opacity' => $option['opacity'] ?? 1,
                'weight' => $option['weight'] ?? 1,
                'title' => $option['text'] ?? $title
            ];
        }
        $legendOptions[] = [
            'type' => 'text',
            'title' => 'Grille de ' . $this->unit / 1000 . 'Km',
            'color' => '#000'
        ];

        return $legendOptions;
    }

    /**
     * @return array|null
     */
    public function getGridPoints(): ?array
    {
        return $this->gridPoints ?? null;
    }

    /**
     * @return array|null
     */
    public function getMarkerBoxes(): ?array
    {
        ksort($this->markersBox, SORT_NUMERIC);
        return $this->markersBox ?? null;
    }


    /**
     * @return array|null
     */
    public function getEmptyBoxes(): ?array
    {
        $emptyBoxes = [];
        foreach ($this->gridPoints as $key => $value) {
            if (!isset($this->markersBox[$key])) {
                $emptyBoxes[$key] = $value;
            }
        }
        return $emptyBoxes;
    }

    /**
     * @param Map $map
     */
    public function createEmptyRectangles(Map $map, $options = []): void
    {
        foreach ($this->getEmptyBoxes() as $emptyBox) {
            $rectangle = new Rectangle($emptyBox['start'], $emptyBox['end']);
            $rectangle->setColor($options['color'] ?? '#000');
            $rectangle->setFillColor($options['fillColor'] ?? '#FF0000');
            $rectangle->setFillOpacity($options['fillOpacity'] ?? 1);
            $rectangle->setOpacity($options['opacity'] ?? 1);
            $rectangle->setWeight($options['weight'] ?? 1);
            $map->addLayer($rectangle);
        }
    }

}
