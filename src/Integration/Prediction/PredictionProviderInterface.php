<?php

namespace rsavinkov\Weather\Integration\Prediction;

use DateTimeInterface;
use rsavinkov\Weather\DTO\PredictionData;

interface PredictionProviderInterface
{
    public function getPartnerName(): string ;

    public function getPredictionData(DateTimeInterface $dateTime): PredictionData;
}
