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

class InstallAssetsCommand extends Command
{
    const SUCCESS = 1;

    const LEAFLET_PICTURES_DIR = 'node_modules/leaflet/dist/images';
    const PUBLIC_PICTURES_DIR  = 'public/bundle/mapux';
    const ASSETS_JS_DIR        = 'assets/js/mapux';
    const RESOURCES_JS_DIR     = 'vendor/frvaillant/mapux/Resources/assets/js';

    protected static $defaultName = 'mapux:install';

    protected function configure()
    {
        $this
            ->setDescription('map ux assets installer');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');
        $io->title('MAPUX INSTALLATION PROCESS');
        $firstQuestion = new ChoiceQuestion('To install MapUx automatically, be sure to have a assets/app.js and having run "yarn install --force" or "npm install --force" before. Continue ? ', [
            'y', 'n'
        ]);
        $firstResponse = $helper->ask($input, $output, $firstQuestion);
        if ('n' === $firstResponse) {
            $io->error('Installation aborted');
            return self::SUCCESS;
        }
        if ('y' === $firstResponse) {

            $appJsFile = __DIR__ . '/../../../../assets/app.js';
            if (is_file($appJsFile)) {
                $appJsFileContent = file_get_contents($appJsFile);
                if (1 === count(explode('frvaillant/mapux', $appJsFileContent))) {
                    $appJsFileContent .= '
require (\'../vendor/frvaillant/mapux/Resources/assets/js/map.js\')
';
                    file_put_contents($appJsFile, $appJsFileContent);
                    $io->success('app.js updated');
                }
            } else {
                $io->error('impossible to find app.js file');
            }

            shell_exec('mkdir -p ' . self::PUBLIC_PICTURES_DIR);

            shell_exec('cp -a ' . self::LEAFLET_PICTURES_DIR . ' ' . self::PUBLIC_PICTURES_DIR);

            $io->success('leaflet pictures added to your project');

            shell_exec('mkdir -p ' . self::ASSETS_JS_DIR);

            shell_exec('cp ' . self::RESOURCES_JS_DIR. '/MapuxEvents.js ' . self::ASSETS_JS_DIR . '/MapuxEvents.js');

            $io->success('MapuxEvents file copied in your project');


        }


        $secondQuestion = new ChoiceQuestion('Do you want us to run "Yarn encode dev" command for you ?', [
            'y', 'n'
        ]);

        $secondResponse = $helper->ask($input, $output, $secondQuestion);

        if ('n' === $secondResponse) {
            $io->warning('Do not forget to run "yarn encore dev" command before using MapUx');
            $io->writeln('******** Make sure your entry points are added in your template ********');
            $io->success('MAPUX INSTALLATION PROCESS ENDED');
            return self::SUCCESS;;
        }
        if ('y' === $secondResponse) {
            $io->comment('Yarn encore dev running ...');
            $result = shell_exec('yarn encore dev');
            $io->block($result);
        }
        $io->writeln('******** Make sure your entry points are added in your template ********');
        $io->success('MAPUX INSTALLATION PROCESS ENDED');

        return self::SUCCESS;
    }
}
