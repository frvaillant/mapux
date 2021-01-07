<?php


namespace MapUx\Model;


class Rectangle extends Layer
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
     * @var array
     */
    protected $firstPoint;

    /**
     * @var array
     */
    protected $secondPoint;




    public function __construct($firstPoint, $secondPoint)
    {
        parent::__construct();
        $this->removeBackground();
        $this->setFirstPoint($firstPoint);
        $this->setSecondPoint($secondPoint);
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
