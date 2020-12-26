<?php
namespace MapUx\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
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
        
            $io->askQuestion(new Question('To install mapux automatically, be sure to have a webpack.config.js file at project root and a templates/base.html.twig'));
            // Webpack.config.js UPDATE
            $entryPointAdder = new EntryPointAdder(__DIR__ . '/../../../../webpack.config.js', $io);
            $entryPointAdder->generateNewWebpackFile();
            
            
            // Base.html.twig update
            $twigBlocksAdder = new TwigBlocksAdder(__DIR__ . '/../../../../templates/base.html.twig', $io);
            $twigBlocksAdder
                ->addMapUxToHead()
                ->addMapUxToFooter()
                ->save();
          

            return self::SUCCESS;
        
    }

}
