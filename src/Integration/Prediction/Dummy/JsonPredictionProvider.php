<?php

namespace rsavinkov\Weather\Integration\Prediction\Dummy;

use DateTime;
use rsavinkov\Weather\DTO\PredictionData;
use rsavinkov\Weather\Integration\Prediction\PredictionProviderInterface;

class JsonPredictionProvider implements PredictionProviderInterface
{
    private const PARTNER_NAME = 'Json partner';

    public function getPartnerName(): string
    {
        return self::PARTNER_NAME;
    }

    public function getPredictionData(): PredictionData
    {
        return new PredictionData(
            file_get_contents(__DIR__.'/data/temps.json'),
            PredictionData::TYPE_JSON,
            $this->getPartnerName(),
            new DateTime()
        );
    }
}
