<?php


namespace MapUx\Command;


class ProjectDirProvider
{
    const AUTHOR = 'frvaillant';

    public function getProjectDir()
    {
            $r = new \ReflectionClass($this);

            $dir = \dirname($r->getFileName());
            $n = 0;
            while ($n === 0) {
                $dir = \dirname($dir);
                if(is_file($dir.'/composer.json') && count(explode(self::AUTHOR, \dirname($dir))) === 1) {
                    $n = 1;
                }
                if ($dir === \dirname($dir)) {
                    return $dir;
                }
            }
           return $dir;
    }

}
