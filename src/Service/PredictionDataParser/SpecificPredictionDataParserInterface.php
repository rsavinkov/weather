<?php

namespace rsavinkov\Weather\Service\PredictionDataParser;

use rsavinkov\Weather\DTO\Prediction;
use rsavinkov\Weather\DTO\PredictionData;

interface SpecificPredictionDataParserInterface
{
    public function support(PredictionData $predictionData): bool;

    /**
     * @param PredictionData $predictionData
     * @return Prediction[]
     */
    public function mapToPredictions(PredictionData $predictionData): array;
}
