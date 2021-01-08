<?php


namespace MapUx\Model;

use \Exception;

abstract class GeojsonLayer extends ShapeLayer
{
    /**
     * @var array
     */
    protected $points;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var array
     */
    protected $json;


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
    public function getPoints(): array
    {
        return $this->points;
    }

    protected function reversePoints(array $points): array
    {
        $reverse = function ($array) {
            return array_reverse($array);
        };

        return array_map($reverse, $points);
    }
    /**
     * @param array $points
     */
    public function setPoints(array $points): void
    {
        $this->points = $this->reversePoints($points);
    }

    /**
     * @return array
     */
    public function getJson(): string
    {
        return json_encode($this->json);
    }

    /**
     * @param array $json
     */
    public function setJson(array $json): void
    {
        $this->json = $json;
    }


}
