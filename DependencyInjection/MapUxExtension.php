<?php

namespace MapUx\DependencyInjection;

use MapUx\Builder\MapBuilder;
use MapUx\Builder\MapBuilderInterface;
use MapUx\Command\InstallAssetsCommand;
use MapUx\Twig\MapFunctionExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Twig\Environment;
use Twig\Extension\ExtensionInterface;
use Twig\NodeVisitor\NodeVisitorInterface;
use Twig\TokenParser\TokenParserInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\TwigTest;


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

        $container
            ->setDefinition('MapUx\Command\InstallAssetsCommand', new Definition(InstallAssetsCommand::class))
            ->setTags([
                'name' => 'console.command',
                'command' => 'mapux:install'
            ])
        ;

        if (class_exists(Environment::class)) {
            $container
                ->setDefinition('mapux.twig_extension', new Definition(MapFunctionExtension::class))
                ->addTag('twig.extension')
                ->setPublic(false)
            ;
        }
    }


}
