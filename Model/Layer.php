<?php


namespace MapUx\Model;


class Layer
{

    const DEFAULT_BACKGROUND = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';

    /**
     * @var string
     */
    private $background;

    /**
     * @var array
     */
    private $options = [];

    /**
     * @var array
     */
    private $events;

    /**
     * @var string
     */
    private $legendName = null;

    /**
     * @var null string
     */
    private $legendType = null;


    public function __construct(string $background = self::DEFAULT_BACKGROUND)
    {
        $this->background = $background;
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
     * @return array
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function getBackground(): string
    {
        return $this->background;
    }

    /**
     * @param string $background
     */
    public function setBackground(string $background): void
    {
        $this->background = $background;
    }

    public function removeBackground()
    {
        $this->setBackground('');
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

    /**
     * @return null
     */
    public function getLegendType()
    {
        return $this->legendType;
    }

    /**
     * @param null $legendType
     */
    public function setLegendType($legendType): void
    {
        $this->legendType = $legendType;
    }



}
