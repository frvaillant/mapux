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
            $appJsFileContent = file_get_contents($appJsFile);
            $appJsFileContent .= '
import \'../vendor/frvaillant/mapux/Resources/assets/css/map.css\'
require (\'../vendor/frvaillant/mapux/Resources/assets/js/map.js\')
require (\'../node_modules/leaflet/dist/leaflet.css\')
';
            file_put_contents($appJsFile, $appJsFileContent);
        }

        $secondQuestion = new ChoiceQuestion('Do you want us to run "Yarn encode dev" command for you ?', [
            'y', 'n'
        ]);

        $secondResponse = $helper->ask($input, $output, $secondQuestion);

        if ('n' === $secondResponse) {
            $io->warning('Do not forget to run "yarn encore dev" command before using MapUx');
            return self::SUCCESS;;
        }
        if ('y' === $secondResponse) {
            $io->comment('Yarn encore dev running ...');
            $result = shell_exec('yarn encore dev');
            $io->block($result);
        }
        return self::SUCCESS;
    }
}
