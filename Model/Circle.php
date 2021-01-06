<?php


namespace MapUx\Model;


class Circle extends Layer
{

    /**
     * @var string
     */
    protected $color = '#0d47a1';

    /**
     * @var string
     */
    protected $fillColor = '#2196f3';

    /**
     * @var integer
     */
    protected $weight = 2;

    /**
     * @var float
     */
    protected $opacity = 1;

    /**
     * @var float
     */
    protected $fillOpacity = 0.5;

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
    
    public function __construct($centerLat, $centerLng, $radius)
    {
        parent::__construct();
        $this->removeBackground();
        $this->setCenterLat($centerLat);
        $this->setCenterLng($centerLng);
        $this->setRadius($radius);
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
