<?php


namespace MapUx\Model;


use MapUx\Command\ProjectDirProvider;

class Icon
{
    private $iconUrl       = '';
    private $shadowUrl     = '';
    private $iconSize      = [25, 41];
    private $iconAnchor    = [12, 41];
    private $popupAnchor   = [1, -34];
    private $tooltipAnchor = [16, -28];
    private $shadowSize    = [41, 41];
    private $className     = '';

    /**
     * @var array
     */
    private $pictures = [];

    public function __construct(string $color = null)
    {
        $this->pictures = $this->getPictures();
        $this->setIconPicture($this->pictures['marker-icon']);
        $this->setShadowPicture($this->pictures['marker-shadow']);
        if(null !== $color) {
            $this->setIconPicture($this->pictures[sprintf('%s-icon', $color)]);
            $this->setShadowPicture($this->pictures['marker-shadow']);
        }

    }

    public function getPictures()
    {
        $projectDirProvider = new ProjectDirProvider();
        $folder = $projectDirProvider->getProjectDir() . '/public/build/images';
        $pictures = [];
        foreach (scandir($folder) as $picture) {
            if (
                $picture !== '.' &&
                $picture !== '..' &&
                substr($picture, -3) === 'png'

            ) {
                list ($name, $id, $ext) = explode('.', $picture);
                $pictures[$name] = '/build/images/' .$picture;
            }
        }
        return $pictures;
    }

    public function render()
    {
        return json_encode([
            'iconUrl'       => $this->getIconPicture(),
            'shadowUrl'     => $this->getShadowPicture(),
            'iconSize'      => $this->getIconSize(),
            'iconAnchor'    => $this->getIconAnchor(),
            'popupAnchor'   => $this->getPopupAnchor(),
            'tooltipAnchor' => $this->getTooltipAnchor(),
            'shadowSize'    => $this->getShadowSize(),
            'className'     => $this->getClassName(),
        ]);
    }

    /**
     * @return string
     */
    public function getIconPicture(): string
    {
        return $this->iconUrl;
    }

    /**
     * @param string $iconUrl
     */
    public function setIconPicture(string $iconUrl): void
    {
        $this->iconUrl = $iconUrl;
    }

    /**
     * @return string
     */
    public function getShadowPicture(): string
    {
        return $this->shadowUrl;
    }

    /**
     * @param string $shadowUrl
     */
    public function setShadowPicture(string $shadowUrl): void
    {
        $this->shadowUrl = $shadowUrl;
    }

    /**
     * @return array
     */
    public function getIconSize(): array
    {
        return $this->iconSize;
    }

    /**
     * @param array $iconSize
     */
    public function setIconSize(array $iconSize): void
    {
        $this->iconSize = $iconSize;
    }

    /**
     * @return array
     */
    public function getIconAnchor(): array
    {
        return $this->iconAnchor;
    }

    /**
     * @param array $iconAnchor
     */
    public function setIconAnchor(array $iconAnchor): void
    {
        $this->iconAnchor = $iconAnchor;
    }

    /**
     * @return array
     */
    public function getPopupAnchor(): array
    {
        return $this->popupAnchor;
    }

    /**
     * @param array $popupAnchor
     */
    public function setPopupAnchor(array $popupAnchor): void
    {
        $this->popupAnchor = $popupAnchor;
    }

    /**
     * @return array
     */
    public function getTooltipAnchor(): array
    {
        return $this->tooltipAnchor;
    }

    /**
     * @param array $tooltipAnchor
     */
    public function setTooltipAnchor(array $tooltipAnchor): void
    {
        $this->tooltipAnchor = $tooltipAnchor;
    }

    /**
     * @return array
     */
    public function getShadowSize(): array
    {
        return $this->shadowSize;
    }

    /**
     * @param array $shadowSize
     */
    public function setShadowSize(array $shadowSize): void
    {
        $this->shadowSize = $shadowSize;
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @param string $className
     */
    public function setClassName(string $className): void
    {
        $this->className = $className;
    }
}
