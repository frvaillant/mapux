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
    const END = 1;

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
        $firstQuestion = new ChoiceQuestion('To install mapux automatically, be sure to have a webpack.config.js file at project root and a templates/base.html.twig. Continue ? ', [
            'y', 'n'
        ]);
        $firstResponse = $helper->ask($input, $output, $firstQuestion);
        if ('n' === $firstResponse) {
            $io->error('Installation aborted');
            return self::SUCCESS;;
        }
        if ('y' === $firstResponse) {
            // Webpack.config.js UPDATE
            $entryPointAdder = new EntryPointAdder(__DIR__ . '/../../../../webpack.config.js', $io);
            $entryPointAdder->generateNewWebpackFile();


            // Base.html.twig update
            $twigBlocksAdder = new TwigBlocksAdder(__DIR__ . '/../../../../templates/base.html.twig', $io);
            $twigBlocksAdder
                ->addMapUxToHead()
                ->addMapUxToFooter()
                ->save();
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
