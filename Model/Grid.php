<?php


namespace MapUx\Model;


use mysql_xdevapi\RowResult;

class Grid extends Layer
{
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



    public function getParameters()
    {
        return [
            'startLat'    => $this->getStartPoint()[0],
            'startLon'    => $this->getStartPoint()[1],
            'endLat'      => $this->getEndPoint()[0],
            'endLon'      => $this->getEndPoint()[1],
            'unit'        => $this->getUnit(),
            'weight'      => $this->getWeight(),
            'color'       => $this->getColor(),
            'fillColor'   => $this->getFillColor(),
            'fillOpacity' => $this->getFillOpacity(),
            'opacity'     => $this->getOpacity()
        ];
    }
}
