<?php
namespace MapUx\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;


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

        $io = new SymfonyStyle();
        $io->writeln('success');

        return self::SUCCESS;
    }

}
