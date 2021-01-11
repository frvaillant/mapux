<?php


namespace MapUx\Services\HtmlBuilder;


class HtmlElement
{
    /**
     * @var bool
     */
    protected $isSingle = false;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $attributes;

    /**
     * @var string
     */
    protected $textContent = null;

    /**
     * HtmlElement constructor.
     * @param $name
     * @param $arguments
     */
    public function __construct($name, $arguments)
    {
        $arguments = $arguments[0];
        $this->name = $name;

        if (isset($arguments['isSingle'])) {
            $this->setIsSingle($arguments['isSingle']);
        }
        if (isset($arguments['attributes'])) {
            $this->setAttributes($arguments['attributes']);
        }
        if (isset($arguments['content'])) {
            $this->setTextContent($arguments['content']);
        }

    }

    /**
     * @return bool
     */
    public function isSingle(): bool
    {
        return $this->isSingle;
    }

    /**
     * @param bool $isSingle
     */
    public function setIsSingle(bool $isSingle): void
    {
        $this->isSingle = $isSingle;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }

    /**
     * @return string
     */
    public function getTextContent(): string
    {
        return htmlspecialchars_decode($this->textContent);
    }

    /**
     * @param string $textContent
     */
    public function setTextContent(string $textContent): void
    {
        $this->textContent = htmlspecialchars($textContent);
    }



    public function open() {
        $html = '<%s ';
        foreach ($this->attributes as $name => $value) {
            $html .= sprintf('%s="%s" ', $name, htmlspecialchars($value));
        }
        $html .= $this->isSingle() ? ' />' : '>';

        if ($this->textContent) {
            $html .= $this->getTextContent();
        }
        return sprintf($html, $this->getName());
    }
}
