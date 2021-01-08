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

    private function encodeContent($content)
    {
        $content = str_replace("'", "&#039;",$content);

        $content = str_replace('"', "&quot;", $content);

        return $content;
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
        $this->content = str_replace("'", "`", $content);
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
