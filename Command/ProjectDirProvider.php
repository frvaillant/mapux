<?php


namespace MapUx\Command;


class ProjectDirProvider
{
    const AUTHOR = 'frvaillant';

    public function getProjectDir()
    {
            $r = new \ReflectionClass($this);

            $dir = \dirname($r->getFileName());
            $n = 1;
            while ($n > 0) {
                $n++;
                $dir = \dirname($dir);
                if(is_file($dir.'/composer.json') && count(explode(self::AUTHOR, \dirname($dir))) === 1) {
                    $n = 0;
                }
                if ($n > 50) {
                    throw new \Exception('Impossible to determinate project directory');
                }
            }
           return $dir;
    }

}
