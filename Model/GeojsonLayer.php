<?php


namespace MapUx\Model;

use \Exception;

abstract class GeojsonLayer extends Layer
{
    /**
     * @var array
     */
    protected $json;

    /**
     * @var string
     */
    protected $fillColor = '#2196f3';

    /**
     * @var string
     */
    protected $color = '#0d47a1';

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
    protected $points;

    /**
     * @var string
     */
    protected $type;
    
    public function __construct(string $background = '')
    {
        parent::__construct($background);
    }

    /**
     * @return string
     */
    public function getJson(): string
    {
        return json_encode($this->json);
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

    public function setJson(array $json)
    {
        $this->json = $json;
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

}
