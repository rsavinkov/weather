<?php

namespace rsavinkov\Weather\Integration\Prediction;

use rsavinkov\Weather\DTO\PredictionData;

interface PredictionProviderInterface
{
    public function getPredictionData(): PredictionData;
}
