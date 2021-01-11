<?php

namespace MapUx\Services\HtmlBuilder;

class HtmlBuilder
{
    /**
     * @var string
     */
    protected $dom = '';

    /**
     * @var array
     */
    protected $openedElements = [];


    public function __call($name, $arguments)
    {
        $element = new HtmlElement($name, $arguments);
        $this->dom .= $element->open();
        if (!$element->isSingle()) {
            $this->openedElements[] = $name;
        }
        return $this;
    }

    public function close()
    {
        if (empty($this->openedElements)) {
            throw new \Exception('No element is opened. Can\'t use close() function');
        }
        $this->dom .= sprintf('</%s>', $this->openedElements[array_key_last($this->openedElements)]);
        $this->openedElements = array_slice($this->openedElements, 0, -1, true);

        return $this;
    }

    public function __toString() {
        if (!empty($this->openedElements)) {
            $errorMessage = 'HTML Structure error : ' . count($this->openedElements);
            $errorMessage .= count($this->openedElements) > 1 ? ' tags are not closed' : ' tag is not closed';
            throw new \Exception($errorMessage);
        }
        return $this->dom;
    }

}
