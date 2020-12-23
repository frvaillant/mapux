<?php


namespace MapUx\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;

class MapUxCommandExtension extends Extension
{
    public function load(ContainerBuilder $container)
    {
        var_dump('hello');
        die;
    }
}
