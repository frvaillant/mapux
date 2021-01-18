<?php


namespace MapUx\Builder;


use MapUx\Command\ProjectDirProvider;
use Symfony\Component\HttpFoundation\Session\Session;

class IconsPictureBuilder
{
    public function build()
    {
        $session = new Session();
        $session->set('MAPUX_ICONS', $this->getIconsPicture());
    }

    public function getIconsPicture()
    {
        $public = $this->getWebpackPath('setOutputPath');
        $rootProvider = new ProjectDirProvider();
        return json_decode(file_get_contents($rootProvider->getProjectDir() . '/' . $public.'/manifest.json'), true);
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
