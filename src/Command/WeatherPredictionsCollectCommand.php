<?php

namespace rsavinkov\Weather\Command;

use rsavinkov\Weather\Service\PredictionsActualizer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
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
        $this
            ->addArgument(
                'upcomingDaysNumber',
                InputArgument::OPTIONAL,
                'For what number of upcoming days do you need to update a weather predictions?',
                10
            )
            ->setDescription('Actualize weather predictions from all providers');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $upcomingDaysNumber = $input->getArgument('upcomingDaysNumber');

        $io = new SymfonyStyle($input, $output);

        $this->predictionsActualizer->updateAll($upcomingDaysNumber, $output);

        $io->success('All weather predictions was actualized!');

        return 0;
    }
}
