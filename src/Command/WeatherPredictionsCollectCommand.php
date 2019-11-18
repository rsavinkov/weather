<?php

namespace rsavinkov\Weather\Command;

use rsavinkov\Weather\Service\PredictionsActualizer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class WeatherPredictionsCollectCommand extends Command
{
    protected static $defaultName = 'weather:predictions:collect';

    private $predictionsActualizer;

    public function __construct(PredictionsActualizer $predictionsActualizer)
    {
        parent::__construct(self::$defaultName);
        $this->predictionsActualizer = $predictionsActualizer;
    }

    protected function configure()
    {
        $this->setDescription('Actualize weather predictions from all providers');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->predictionsActualizer->updateAll($output);

        $io->success('All weather predictions was actualized!');

        return 0;
    }
}
