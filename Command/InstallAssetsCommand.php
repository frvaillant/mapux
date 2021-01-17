<?php

namespace MapUx\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Question\ConfirmationQuestion;


class InstallAssetsCommand extends Command
{

    const SUCCESS = 1;
    const ERROR = 0;

    const ASSETS_JS_DIR        = '/assets/js/mapux';
    const RESOURCES_JS_DIR     = '/vendor/frvaillant/mapux/Resources/assets/js';
    const APP_JS_FILE          = '/assets/app.js';

    protected static $defaultName = 'mapux:install';


    protected function configure()
    {
        $this->setDescription('map ux assets installer');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $projectDirProvider = new ProjectDirProvider();

        $ROOT_DIR = $projectDirProvider->getProjectDir();

        $errors = [];

        $io = new SymfonyStyle($input, $output);

        $helper = $this->getHelper('question');
        $io->title('MAPUX INSTALLATION PROCESS');
        $io->writeln('<fg=green>To install MapUx automatically, please, make sure :</>');
        $io->listing([
            'having ran "yarn install --force" or "npm install --force"',
            'have an assets/app.js file in your project',
            'have a webpack.config.js file at project root'
        ]);
        $firstQuestion = new ChoiceQuestion('<fg=green>Let\'s go ?</> ', [
            'y', 'n'
        ]);
        $firstResponse = $helper->ask($input, $output, $firstQuestion);
        if ('n' === $firstResponse) {
            $io->error('Installation aborted');
            return self::SUCCESS;
        }

        if ('y' === $firstResponse) {

            if (is_file($ROOT_DIR . self::APP_JS_FILE)) {

                $appJsFileContent = file_get_contents($ROOT_DIR . self::APP_JS_FILE);

                if (1 === count(explode('frvaillant/mapux', $appJsFileContent))) {
                    $appJsFileContent .= '
require (\'@frvaillant/mapux/js/map.js\')';
                    file_put_contents($ROOT_DIR . self::APP_JS_FILE, $appJsFileContent);
                }

            } else {
                $errors[] = '* impossible to find your app.js file. Please require "@frvaillant/mapux/js/map.js" in your app.js file';
                $io->error('impossible to find app.js file');
            }

            try {
                if (!file_exists($ROOT_DIR . self::ASSETS_JS_DIR)) {
                    mkdir($ROOT_DIR . self::ASSETS_JS_DIR);
                }
            } catch(\Exception $e) {
                $errors[] = '* Impossible to create directory ' . $ROOT_DIR . self::ASSETS_JS_DIR;
            }
            if (!is_file($ROOT_DIR . self::ASSETS_JS_DIR . '/MapuxEvents.js')) {
                try {
                    copy($ROOT_DIR . self::RESOURCES_JS_DIR . '/MapuxEvents.js', $ROOT_DIR . self::ASSETS_JS_DIR . '/MapuxEvents.js');
                } catch(\Exception $e) {
                    $errors[] = ' * Impossible to add ' . $ROOT_DIR . self::RESOURCES_JS_DIR .'/MapuxEvents.js into ' . $ROOT_DIR . self::ASSETS_JS_DIR . 'directory';
                }
            }

            if (is_file($ROOT_DIR . '/webpack.config.js')) {

                try {
                    $webpackConfig = file_get_contents($ROOT_DIR . '/webpack.config.js');

                    if (count(explode('mapux', $webpackConfig)) === 1) {
                        $replace = 'Encore = require(\'@symfony/webpack-encore\');

Encore.addAliases({
    \'mapuxevents\': __dirname + \'/assets/js/mapux\'
})
';
                        if (count(explode('Encore = require(\'@symfony/webpack-encore\');', $webpackConfig)) === 2) {
                            $webpackConfig = str_replace("Encore = require('@symfony/webpack-encore');", $replace, $webpackConfig);
                            file_put_contents($ROOT_DIR . '/webpack.config.js', $webpackConfig);
                        } else {
                            $errors[] = 'We were not able to edit your Webpack.config.js file. Please refer to documentation to update your file';
                        }
                    }
                } catch(\Exception $e) {
                    $errors[] = 'We were not able to edit your Webpack.config.js file. Please refer to documentation to update your file';
                }

            } else {
                $errors[] = 'Impossible to find your webpack.congig.js file';
            }
        }


        if (count($errors) > 0) {
            $io->error('Some errors have occured during installation');
            foreach ($errors as $error) {
                $io->block('<fg=red>' . $error . '</>');
            }
            return self::ERROR;
        }

        $io->success('MAPUX INSTALLATION PROCESS ENDED');
        $io->newLine();
        $io->writeln('<info>*************************************</>');
        $io->writeln('Do not forget to run <info>yarn encore dev</>');
        $io->writeln('<info>*************************************</>');
        $io->newLine();


        return self::SUCCESS;
    }



    /**
     * @param $source
     * @param $destination
     */
    private function copyFiles($source, $destination) {
        $dir = opendir($source);
        if(!file_exists($destination)) {
            mkdir($destination);
        }
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file !== '.' ) && ( $file !== '..' )) {
                if ( !is_dir($source . '/' . $file) ) {
                    copy($source . '/' . $file,$destination . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
}
