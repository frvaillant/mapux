<?php


namespace MapUx\Model;


class AdjustableGrid extends Layer
{
    /**
     * @var string
     */
    protected $color = '#000';

    /**
     * @var integer
     */
    protected $weight = 1;

    public function __construct()
    {
        parent::__construct();
        $this->removeBackground();
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
}
