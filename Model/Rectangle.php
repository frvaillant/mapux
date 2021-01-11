<?php


namespace MapUx\Model;


use MapUx\Services\GeoServicesTrait;

class Rectangle extends ShapeLayer
{
    /**
     * @var array
     */
    protected $firstPoint;

    /**
     * @var array
     */
    protected $secondPoint;

    use GeoServicesTrait;

    public function __construct($firstPoint, $secondPoint)
    {
        parent::__construct();
        $this->removeBackground();
        $this->setFirstPoint($firstPoint);
        $this->setSecondPoint($secondPoint);
        $this->setLegendType('square');
    }

    public function getSurface()
    {
        $d1 = $this->distanceBetween($this->firstPoint[0], $this->firstPoint[1], $this->firstPoint[0], $this->secondPoint[1]);
        $d2 = $this->distanceBetween($this->firstPoint[0], $this->secondPoint[1], $this->secondPoint[0], $this->secondPoint[1]);

        return round($d1 * $d2, 2);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function getFirstPoint(): array
    {
        return $this->firstPoint;
    }

    /**
     * @param array $firstPoint
     */
    public function setFirstPoint(array $firstPoint): void
    {
        $this->firstPoint = $firstPoint;
    }

    /**
     * @return array
     */
    public function getSecondPoint(): array
    {
        return $this->secondPoint;
    }

    /**
     * @param array $secondPoint
     */
    public function setSecondPoint(array $secondPoint): void
    {
        $this->secondPoint = $secondPoint;
    }


}
