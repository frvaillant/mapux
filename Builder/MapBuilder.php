<?php


namespace MapUx\Builder;


use MapUx\Builder\MapBuilderInterface;
use MapUx\Command\ProjectDirProvider;
use MapUx\Model\Map;


class MapBuilder implements MapBuilderInterface
{
    public function __construct()
    {
        $this->buildMap();
    }

    public function createMap(float $latitude = Map::DEFAULT_LAT, float $longitude = Map::DEFAULT_LON, int $zoomLevel = Map::DEFAULT_ZOOM, string $background = null): Map
    {
        return new Map($latitude, $longitude, $zoomLevel, $background);;
    }

    public function buildMap()
    {
        $map = new \ReflectionClass(Map::class);
        $file = $map->getFileName();
        $content = file_get_contents($file);
        $content = $this->prepareFile($content);
        $content = str_replace('const MAPUX_ICONS = [];', $this->makeIconsStr(), $content);
        file_put_contents($file, $content);
    }

    private function prepareFile($content)
    {
        list($startFile, $endFile) = explode('const MAPUX_ICONS = [', $content);
        $parts = explode('];', $endFile);
        unset($parts[0]);
        $endfile = implode('];', $parts);
        return $startFile . 'const MAPUX_ICONS = [];' . $endfile;
    }

    private function getPictures()
    {
        $projectDirProvider = new ProjectDirProvider();
        $folder = $projectDirProvider->getProjectDir() . '/' . $this->getWebpackPath('setOutputPath') . '/images';
        $pictures = [];
        foreach (scandir($folder) as $picture) {
            if (
                $picture !== '.' &&
                $picture !== '..' &&
                substr($picture, -3) === 'png'

            ) {
                list ($name, $id, $ext) = explode('.', $picture);
                $pictures[$name] = $this->getWebpackPath('setPublicPath') . '/images/' .$picture;
            }
        }
        return $pictures;
    }

    private function makeIconsStr()
    {
        $pictures = $this->getPictures();
        $str = 'const MAPUX_ICONS = [
            ';
        foreach ($pictures as $key => $picture) {
            $str .= '\'' . $key . '\' => \'' . $picture . '\',
            ';
        }
        $str .= '];';
        return $str;
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

}
