<?php

namespace MapUx\Command;

use PhpParser\Error;
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
    const ERROR = 0;

    const LEAFLET_PICTURES_DIR = __DIR__ . '/../../../../node_modules/leaflet/dist/images';
    const PUBLIC_PICTURES_DIR  = __DIR__ . '/../../../../public/bundle/mapux';
    const ASSETS_JS_DIR        = __DIR__ . '/../../../../assets/js/mapux';
    const RESOURCES_JS_DIR     = __DIR__ . '/../Resources/assets/js';
    const RESOURCES_IMAGES_DIR = __DIR__ . '/../Resources/assets/images';
    const APP_JS_FILE          = __DIR__ . '/../../../../assets/app.js';
    const PUBLIC_DIR           = __DIR__ . '/../../../../public';
    const BUNDLE_DIR           = __DIR__ . '../../../../public/bundle';

    protected static $defaultName = 'mapux:install';

    protected function configure()
    {
        $this
            ->setDescription('map ux assets installer');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $errors = [];

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
            if (is_file(self::APP_JS_FILE)) {
                $appJsFileContent = file_get_contents(self::APP_JS_FILE);
                if (1 === count(explode('frvaillant/mapux', $appJsFileContent))) {
                    $appJsFileContent .= '
require (\'../vendor/frvaillant/mapux/Resources/assets/js/map.js\')
';
                    file_put_contents(self::APP_JS_FILE, $appJsFileContent);
                }
            } else {
                $errors[] = '* impossible to find your app.js file. Please require "[..]/vendor/frvaillant/mapux/Resources/assets/js/map.js" in your app.js file';
                $io->error('impossible to find app.js file');
            }

            try {
                if (!file_exists(self::PUBLIC_PICTURES_DIR)) {
                    mkdir (self::BUNDLE_DIR, 0777, true);
                    mkdir(self::PUBLIC_PICTURES_DIR, 0777, true);
                }
            } catch(\Exception $e) {
                $errors[] = '* Impossible to create ' . self::PUBLIC_PICTURES_DIR .' directory' . PHP_EOL .
                    'Create the /bundle/mapux directory-ies in your public directory and give it rights to write in it (chmod 755 path-to-folder).' . PHP_EOL .
                    'Then relaunch command';
            }

            try {
                $this->copyFiles(self::RESOURCES_IMAGES_DIR, self::PUBLIC_PICTURES_DIR);
            } catch(\Exception $e) {
                $errors[] = '* Impossible to copy pictures from ' . self::RESOURCES_IMAGES_DIR .' to ' . self::PUBLIC_PICTURES_DIR;
            }

            try {
                if (!file_exists(self::ASSETS_JS_DIR)) {
                    mkdir(self::ASSETS_JS_DIR);
                }
            } catch(\Exception $e) {
                $errors[] = '* Impossible to create directory ' . self::ASSETS_JS_DIR;
            }
            if (!is_file(self::ASSETS_JS_DIR . '/MapuxEvents.js')) {
                try {
                    copy(self::RESOURCES_JS_DIR . '/MapuxEvents.js', self::ASSETS_JS_DIR . '/MapuxEvents.js');
                } catch(\Exception $e) {
                    $errors[] = ' * Impossible to add ' . self::RESOURCES_JS_DIR .'/MapuxEvents.js into ' . self::ASSETS_JS_DIR . 'directory';
                }
            }

        }

        if(0 === count($errors)) {
            $secondQuestion = new ChoiceQuestion('Do you want us to run "Yarn encore dev" command for you ?', [
                'y', 'n'
            ]);

            $secondResponse = $helper->ask($input, $output, $secondQuestion);

            if ('n' === $secondResponse) {
                $io->warning('Do not forget to run "yarn encore dev" command before using MapUx');
            }
            if ('y' === $secondResponse) {
                $io->comment('Yarn encore dev running ...');
                $result = shell_exec('yarn encore dev');
                $io->block($result);
            }
        }

        if (count($errors) > 0) {
            $io->error('Some errors have occured during installation');
            foreach ($errors as $error) {
                $io->block($error);
            }
            return self::ERROR;
        }

        $io->success('MAPUX INSTALLATION PROCESS ENDED');
        return self::SUCCESS;
    }

    private function recursiveCopyFiles($source, $destination) {
        $dir = opendir($source);
        mkdir($destination);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file !== '.' ) && ( $file !== '..' )) {
                if ( is_dir($source . '/' . $file) ) {
                    recurse_copy($source . '/' . $file, $destination . '/' . $file);
                }
                else {
                    copy($source . '/' . $file,$destination . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

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
