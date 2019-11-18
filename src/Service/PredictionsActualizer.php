<?php

namespace rsavinkov\Weather\Service;

use rsavinkov\Weather\Integration\Prediction\PredictionProviderInterface;
use rsavinkov\Weather\Repository\WeatherPredictionRepository;
use rsavinkov\Weather\Service\PredictionDataParser\PredictionDataParser;
use Symfony\Component\Console\Output\OutputInterface;

class PredictionsActualizer
{
    private $weatherPredictionRepository;
    private $predictionDataParser;
    private $integrations;

    public function __construct(
        WeatherPredictionRepository $weatherPredictionRepository,
        PredictionDataParser $predictionDataParser,
        PredictionProviderInterface ...$integrations
    ) {
        $this->weatherPredictionRepository = $weatherPredictionRepository;
        $this->predictionDataParser = $predictionDataParser;
        $this->integrations = $integrations;
    }

    public function updateAll(?OutputInterface $output = null)
    {
        foreach ($this->integrations as $integration) {
            $this->writeln($output,"Getting predictions from {$integration->getPartnerName()}");
            $predictionData = $integration->getPredictionData();
            $predictions = $this->predictionDataParser->mapToPredictions($predictionData);
            $this->writeln($output,"Predictions number: " . count($predictions));
            $this->weatherPredictionRepository->updateFromPredictions(...$predictions);
            $this->writeln($output, 'Done!');
        }
    }

    private function writeln(?OutputInterface $output, string $message)
    {
        if ($output) {
            $output->writeln($message);
        }
    }
}
