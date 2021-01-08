<?php


namespace MapUx\Model;


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
