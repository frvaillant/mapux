<?php


namespace MapUx\Model;

use \Exception;

class GeojsonLayer extends Layer
{
    /**
     * @var array
     */
    protected $json;

    public function __construct(string $json, string $background = '')
    {
        try {
            $this->json = json_decode($json, true);
        } catch(Exception $e) {
            $e->getMessage();
        }
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
