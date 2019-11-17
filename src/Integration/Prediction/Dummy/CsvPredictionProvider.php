<?php

namespace rsavinkov\Weather\Integration\Prediction\Dummy;

use DateTime;
use rsavinkov\Weather\DTO\PredictionData;
use rsavinkov\Weather\Integration\Prediction\PredictionProviderInterface;

class CsvPredictionProvider implements PredictionProviderInterface
{
    private const PARTNER_NAME = 'CSV partner';

    public function getPredictionData(): PredictionData
    {
        return new PredictionData(
            file_get_contents(__DIR__.'data/temps.csv'),
            PredictionData::TYPE_CSV,
            self::PARTNER_NAME,
            new DateTime()
        );
    }
}