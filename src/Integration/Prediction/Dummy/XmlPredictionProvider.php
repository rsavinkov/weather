<?php

namespace rsavinkov\Weather\Integration\Prediction\Dummy;

use DateTime;
use rsavinkov\Weather\DTO\PredictionData;
use rsavinkov\Weather\Integration\Prediction\PredictionProviderInterface;

class XmlPredictionProvider implements PredictionProviderInterface
{
    private const PARTNER_NAME = 'XML partner';

    public function getPredictionData(): PredictionData
    {
        return new PredictionData(
            file_get_contents(__DIR__.'data/temps.xml'),
            PredictionData::TYPE_XML,
            self::PARTNER_NAME,
            new DateTime()
        );
    }
}
