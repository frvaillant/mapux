<?php


namespace MapUx\Model;


class IgnLayer extends Layer
{
    const IGN_LAYERS = [
        'CADASTRALPARCELS.PARCELLAIRE_EXPRESS' => [
            'style'  => 'PCI vecteur',
            'format' => 'image/png'
        ],
        'ELEVATION.SLOPES' => [
            'style'  => 'normal',
            'format' => 'image/jpeg'
        ],
        'GEOGRAPHICALGRIDSYSTEMS.PLANIGNV2' => [
            'style'  => 'normal',
            'format' => 'image/png'
        ],
        'LIMITES_ADMINISTRATIVES_EXPRESS.LATEST' => [
            'style'  => 'normal',
            'format' => 'image/png'
        ],
        'ORTHOIMAGERY.ORTHOPHOTOS' => [
            'style'  => 'normal',
            'format' => 'image/jpeg'
        ],
        'ORTHOIMAGERY.ORTHOPHOTOS' => [
            'style'  => 'normal',
            'format' => 'image/jpeg'
        ],
    ];

    const GEOSERVICE_API_LINK =
        'https://wxs.ign.fr/%s/geoportail/wmts?SERVICE=WMTS&REQUEST=GetTile' .
        '&VERSION=1.0.0&LAYER=%s&TILEMATRIXSET=PM&TILEMATRIX={z}&TILECOL={x}&TILEROW={y}&STYLE=%s&FORMAT=%s';

    /**
     * @var string API KEY FOR GEOSERVICES
     */
    private $key = null;

    public function __construct(string $key, string $ressource, string $background = parent::DEFAULT_BACKGROUND)
    {
        parent::__construct($background);

        $this->key = $key;
        if(null !== $ressource) {
            $this->setResource($ressource);
        }
    }

    private function setResource(string $layerType)
    {
        if (!$this->key) {
            throw new \Exception('You need a Geoservice Api Key to use IgnLayer. Get your key at : https://www.sphinxonline.com/SurveyServer/s/etudesmk/Geoservices/questionnaire.htm');
        }

        if (!isset(self::IGN_LAYERS[$layerType])) {
            throw new \Exception('This layer resource doesn\'t exist in MapUx');
        }

        $this->setBackground(
            sprintf(self::GEOSERVICE_API_LINK,
                $this->key,
                $layerType,
                self::IGN_LAYERS[$layerType]['style'],
                self::IGN_LAYERS[$layerType]['format']
            )
        );
    }
}
