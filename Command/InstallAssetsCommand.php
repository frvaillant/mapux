<?php
namespace MapUx\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

class InstallAssetsCommand extends Command
{
    const SUCCESS = 1;

    protected static $defaultName = 'mapux:install';
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
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

        return self::SUCCESS;
    }

}
