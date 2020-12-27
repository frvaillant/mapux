<?php

namespace MapUx\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class UninstallAssetsCommand extends Command
{
    const SUCCESS = 1;

    protected static $defaultName = 'mapux:uninstall';

    protected function configure()
    {
        $this
            ->setDescription('map ux assets uninstaller');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');
        $io->title('REMOVING MAPUX PROCESS');
        $io->block('We will not do it for you but we give you the list of things to do : ');
        $io->block('step 1 :: remove these lines from your Webpack.config.js file : 
        Encore
        .addEntry(\'mapux\', \'./vendor/frvaillant/mapux/Resources/assets/mapux.js\')
        .copyFiles({
        from: \'./node_modules/leaflet/dist/images\',
        to: \'images/[path][name].[ext]\',
        })');

        $io->block('step 2 :: removing blocks from base.html.twig');
        $io->block('remove 
        {% block cssmapux %}
        {{ encore_entry_link_tags(\'mapux\') }}
        {% endblock %} from your <head> section and remove 
        {% block scriptsmapux %}
        {{ encore_entry_script_tags(\'mapux\') }}
        {% endblock %} from your <footer> section');

        $io->block('step 3 :: run "npm remove leaflet"');
        $io->block('step 4 :: run "composer remove frvaillant/mapux"');
        $io->block('step 5 :: run "yarn encore dev"');


        return self::SUCCESS;

    }

}
