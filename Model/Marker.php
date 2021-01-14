<?php


namespace MapUx\Model;


class Marker
{
    const DEFAULT_LAT  = 44.8485138261124;
    const DEFAULT_LON  = -0.563934445381165;

    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

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

    /**
     * @var string
     */
    private $legendName = null;

    public function __construct(float $latitude = self::DEFAULT_LAT, float $longitude = self::DEFAULT_LON)
    {
        $this->setLatitude($latitude);
        $this->setLongitude($longitude);
        $this->icon = new Icon();
    }

    /**
     * @return string
     */
    public function getLegendName(): ?string
    {
        return $this->legendName;
    }

    /**
     * @param string $legendName
     */
    public function setLegendName(string $legendName): void
    {
        $this->legendName = htmlspecialchars($legendName);
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
        return $this->icon->render();
    }

    /**
     * @param mixed $icon
     */
    public function setIcon(Icon $icon): void
    {
        $this->icon = $icon;
    }

    public function getIconObject()
    {
        return $this->icon;
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
                'content' => htmlspecialchars($this->popup->getContent()),
                'options' => $this->popup->getOptions()
            ]);
        }
        return null;
    }

    public function addEvent(string $eventName, $action, $params = null)
    {
        $this->events[$eventName] = [$action, $params];
    }

    /**
     * @return array
     */
    public function getEvents(): ?string
    {
        if ($this->events) {
            $events = [];
            foreach ($this->events as $name => [$action, $params]) {
                $events[] = [
                    'name'   => $name,
                    'action' => $action,
                    'params' => $params ?? null,
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
