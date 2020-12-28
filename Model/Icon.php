<?php


namespace MapUx\Model;


class Icon
{
    private $iconUrl = '/build/images/marker-icon.png';
    private $shadowUrl = '/build/images/marker-shadow.png';
    private $iconSize = [25, 41];
    private $iconAnchor = [12, 41];
    private $popupAnchor = [1, -34];
    private $tooltipAnchor = [16, -28];
    private $shadowSize = [41, 41];

    public function __construct()
    {
    }

    public function render()
    {
        return json_encode([
            'iconUrl' => $this->getIconUrl(),
            'shadowUrl' => $this->getShadowUrl(),
            'iconSize' => $this->getIconSize(),
            'iconAnchor' => $this->getIconAnchor(),
            'popupAnchor' => $this->getPopupAnchor(),
            'tooltipAnchor' => $this->getTooltipAnchor(),
            'shadowSize' => $this->getShadowSize()
        ]);
    }

    /**
     * @return string
     */
    public function getIconUrl(): string
    {
        return $this->iconUrl;
    }

    /**
     * @param string $iconUrl
     */
    public function setIconUrl(string $iconUrl): void
    {
        $this->iconUrl = $iconUrl;
    }

    /**
     * @return string
     */
    public function getShadowUrl(): string
    {
        return $this->shadowUrl;
    }

    /**
     * @param string $shadowUrl
     */
    public function setShadowUrl(string $shadowUrl): void
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
}
