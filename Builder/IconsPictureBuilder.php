<?php


namespace MapUx\Builder;


use MapUx\Command\ProjectDirProvider;
use Symfony\Component\HttpFoundation\Session\Session;

class IconsPictureBuilder
{
    public function getIconsPicture()
    {
        $public = $this->getWebpackPath('setOutputPath');
        $rootProvider = new ProjectDirProvider();
        return json_decode(file_get_contents($rootProvider->getProjectDir() . '/' . $public.'/manifest.json'), true);
    }

    private function getWebpackPath($search)
    {
        $projectRootProvider = new ProjectDirProvider();
        $content = file_get_contents($projectRootProvider->getProjectDir() . '/webpack.config.js');
        preg_match('#' . $search . '\(\'(.*?)\'\)#', $content, $path);
        return $path[1];
    }

    public function getBuildUrl()
    {
        return str_replace('/', '', $this->getWebpackPath('setPublicPath'));
    }
}
