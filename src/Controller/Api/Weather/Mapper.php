<?php

namespace rsavinkov\Weather\Controller\Api\Weather;

use rsavinkov\Weather\DTO\Api\Weather\Prediction;
use rsavinkov\Weather\DTO\Api\Weather\Response;
use rsavinkov\Weather\DTO\AveragePrediction;
use rsavinkov\Weather\Service\ScaleConverter\ScaleConverter;

class Mapper
{
    private $scaleConverter;

    public function __construct(ScaleConverter $scaleConverter)
    {
        $this->scaleConverter = $scaleConverter;
    }

    public function mapAveragePredictionsToResponse(string $scale, AveragePrediction ...$averagePredictions): Response
    {
        $response = new Response();
        foreach ($averagePredictions as $averagePrediction) {
            $response->addPrediction(
                new Prediction(
                    $averagePrediction->city,
                    $averagePrediction->predictionsDateTime->format('Y-m-d H:i:s'),
                    $scale,
                    $this->scaleConverter->fromCelsius($scale, $averagePrediction->celsiusTemperature),
                    $averagePrediction->updatedAt->getTimestamp()
                )
            );
        }

        return $response;
    }
}
