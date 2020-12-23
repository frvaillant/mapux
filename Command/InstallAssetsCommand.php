<?php


class InstallAssetsCommand extends \Symfony\Component\Console\Command\Command
{

    protected static $defaultName = 'mapux:install';

    public function __construct(\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
        // you *must* call the parent constructor
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('map ux assets installer');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->logger->info('Waking up the sun');
        // ...

        return Command::SUCCESS;
    }

}
