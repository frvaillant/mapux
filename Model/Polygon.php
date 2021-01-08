<?php


namespace MapUx\Model;

use MapUx\Model\Shape;

final class Polygon extends GeojsonLayer
{
    const SHAPE_TYPE = 'polygon';

    private $structure = '{
      "type": "FeatureCollection",
      "features": [
        {
          "type": "Feature",
          "properties": {},
          "geometry": {
            "type": "Polygon",
            "coordinates": [
              [
                
              ]
            ]
          }
        }
      ]
    }';


    public function __construct(array $points)
    {
        parent::__construct('');
        $this->removeBackground();
        $this->setType(self::SHAPE_TYPE);
        $this->setPoints($points);
        $this->makeJson();
    }

    private function makeJson()
    {
        $json = json_decode($this->structure, true);
        $json['features'][0]['geometry']['coordinates'][0] = $this->points;

        $this->setJson($json);
    }


}
