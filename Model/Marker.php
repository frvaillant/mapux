<?php


namespace MapUx\Model;


class Marker
{

    /**
     * @var float
     */
    private float $latitude;

    /**
     * @var float
     */
    private float $longitude;

    private $icon;

    public function __construct($latitude, $longitude)
    {
        $this->setLatitude($latitude);
        $this->setLongitude($longitude);
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude(float $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude(float $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return json_encode([
            'iconUrl' => $this->icon->getIconUrl(),
            'shadowUrl' => $this->icon->getShadowUrl(),
            'iconSize' => $this->icon->getIconSize(),
            'iconAnchor' => $this->icon->getIconAnchor(),
            'popupAnchor' =>  $this->icon->getPopupAnchor(),
            'tooltipAnchor' =>  $this->icon->getTooltipAnchor(),
            'shadowSize' => $this->icon->getShadowSize()
        ]);
    }

    /**
     * @param mixed $icon
     */
    public function setIcon(Icon $icon): void
    {
        $this->icon = $icon;
    }

}
