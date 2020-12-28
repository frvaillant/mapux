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

    /**
     * @var Icon
     */
    private $icon;

    /**
     * @var array
     */
    private $options;

    /**
     * @var Popup
     */
    private $popup;

    /**
     * @var array
     */
    private $events;

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
        if ($this->icon) {
            return json_encode([
                'iconUrl' => $this->icon->getIconUrl(),
                'shadowUrl' => $this->icon->getShadowUrl(),
                'iconSize' => $this->icon->getIconSize(),
                'iconAnchor' => $this->icon->getIconAnchor(),
                'popupAnchor' => $this->icon->getPopupAnchor(),
                'tooltipAnchor' => $this->icon->getTooltipAnchor(),
                'shadowSize' => $this->icon->getShadowSize()
            ]);
        }
    }

    /**
     * @param mixed $icon
     */
    public function setIcon(Icon $icon): void
    {
        $this->icon = $icon;
    }

    /**
     * @return array
     */
    public function getOptions(): string
    {
        if (isset($this->options['icon'])) {
            $this->options['icon'] = $this->options['icon']->render();
        }
        return json_encode($this->options);
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    public function addPopup(Popup $popup)
    {
        $this->popup = $popup;
    }

    public function getPopup()
    {
        if ($this->popup) {
            return json_encode([
                'content' => $this->popup->getContent(),
                'options' => $this->popup->getOptions()
            ]);
        }
        return null;
    }

    public function addEvent(string $eventName, $action)
    {
        $this->events[$eventName] = $action;
    }

    /**
     * @return array
     */
    public function getEvents(): ?string
    {
        if ($this->events) {
            $events = [];
            foreach ($this->events as $name => $action) {
                $events[] = [
                    'name' =>$name,
                    'action' => $action,
                ];
            }
            return json_encode($events);
        }
        return null;
    }

    /**
     * @param array $events
     */
    public function setEvents(array $events): void
    {
        $this->events = $events;
    }
}
