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
    private $options;



    public function __construct(string $background = self::DEFAULT_BACKGROUND)
    {
        $this->background = $background;
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
}
