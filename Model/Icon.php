<?php


namespace MapUx\Model;


use MapUx\Command\ProjectDirProvider;
use MapUx\Model\Map;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy;

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

    public function __construct(string $color = null)
    {
        $public = $this->getWebpackPath('setOutputPath');
        $build  = str_replace('/', '', $this->getWebpackPath('setPublicPath'));
        $rootProvider = new ProjectDirProvider();
        $package = new Package(new JsonManifestVersionStrategy($rootProvider->getProjectDir() . '/' . $public.'/manifest.json'));

        $build  = str_replace('/', '', $this->getWebpackPath('setPublicPath'));
        $this->setIconPicture($package->getUrl($build . '/images/marker-icon.png'));
        $this->setShadowPicture($package->getUrl($build . '/images/marker-shadow.png'));
        if(null !== $color) {
            $this->setIconPicture($package->getUrl($build . '/images/' . $color . '-icon.png'));
            $this->setShadowPicture($package->getUrl($build . '/images/marker-shadow.png'));
        }
    }

    private function getWebpackPath($search)
    {
        $projectRootProvider = new ProjectDirProvider();
        $root = $projectRootProvider->getProjectDir();
        $file = $root . '/webpack.config.js';
        $content = file_get_contents($file);
        list ($start, $public) = explode($search . '(', $content);
        list ($path, $rest) = explode(')', $public);
        $path = str_replace("'", '', $path);
        $path = str_replace('"', '', $path);
        return $path;
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
