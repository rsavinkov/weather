<?php

namespace rsavinkov\Weather\Integration\Prediction\Dummy;

use DateTime;
use rsavinkov\Weather\DTO\PredictionData;
use rsavinkov\Weather\Integration\Prediction\PredictionProviderInterface;

class JsonPredictionProvider implements PredictionProviderInterface
{
    private const PARTNER_NAME = 'Json partner';

    public function getPredictionData(): PredictionData
    {
        return new PredictionData(
            file_get_contents(__DIR__.'data/temps.json'),
            PredictionData::TYPE_JSON,
            self::PARTNER_NAME,
            new DateTime()
        );
    }
}
