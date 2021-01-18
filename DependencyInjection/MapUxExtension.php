<?php

namespace MapUx\DependencyInjection;

use MapUx\Builder\MapBuilder;
use MapUx\Builder\MapBuilderInterface;
use MapUx\Twig\MapFunctionExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Twig\Environment;
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;

class MapUxExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $container
            ->setDefinition('mapux.builder', new Definition(MapBuilder::class))
            ->setPublic(false)
        ;

        $container
            ->setAlias(MapBuilderInterface::class, 'mapux.builder')
            ->setPublic(false)
        ;

        if (class_exists(Environment::class)) {
            $container
                ->setDefinition('mapux.twig_extension', new Definition(MapFunctionExtension::class))
                ->addTag('twig.extension')
                ->setPublic(false)
            ;
        }

        $loader = new XmlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Config')
        );
        $loader->load('services.xml');
    }
}
