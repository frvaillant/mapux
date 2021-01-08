<?php


namespace MapUx\Model;


class Circle extends ShapeLayer
{
    /**
     * @var float
     */
    protected $centerLat;

    /**
     * @var float
     */
    protected $centerLng;

    /**
     * @var integer
     */
    protected $radius;

    public function __construct(float $centerLat, float $centerLng, int $radius)
    {
        parent::__construct();
        $this->removeBackground();
        $this->setCenterLat($centerLat);
        $this->setCenterLng($centerLng);
        $this->setRadius($radius);
        $this->setLegendType('circle');
    }

    /**
     * @return float
     */
    public function getCenterLat(): float
    {
        return $this->centerLat;
    }

    /**
     * @param float $centerLat
     */
    public function setCenterLat(float $centerLat): void
    {
        $this->centerLat = $centerLat;
    }

    /**
     * @return float
     */
    public function getCenterLng(): float
    {
        return $this->centerLng;
    }

    /**
     * @param float $centerLng
     */
    public function setCenterLng(float $centerLng): void
    {
        $this->centerLng = $centerLng;
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
    public function getCenter(): array
    {
        return [$this->getCenterLat(), $this->getCenterLng()];
    }

    /**
     * @return int
     */
    public function getRadius(): int
    {
        return $this->radius;
    }

    /**
     * @param int $radius
     */
    public function setRadius(int $radius): void
    {
        $this->radius = $radius;
    }




}
