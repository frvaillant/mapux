<?php


namespace MapUx\Model;


class GeojsonLayer extends Layer
{
    /**
     * @var array
     */
    protected $json;

    public function __construct(string $json, string $background = '')
    {
        $this->json = json_decode($json, true);
        parent::__construct($background);
    }

    /**
     * @return string
     */
    public function getJson(): string
    {
        return json_encode($this->json);
    }



}
