<?php

namespace MapUx\DependencyInjection;

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
use MapUx\Command\InstallAssetsCommand;

class MapUxCommandExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $container
            ->setDefinition('mapux.install.command', new Definition(InstallAssetsCommand::class))
            ->addTag('console.command')
            ->setArguments([
                'name'    => 'console.command',
                'command' => 'mapux:install'
            ])
        ;
    }


}
