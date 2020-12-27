<?php


namespace MapUx\Model;


/**
 * Class Popup
 * @package MapUx\Model
 */
class Popup
{
    /**
     * @var string 
     */
    private $content = "";

    /**
     * @var array 
     */
    private $options = [];
    
    public function __construct($content = null)
    {
        $this->setContent($content);
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return array
     */
    public function getOptions(): array
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

}
