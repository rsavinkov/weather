<?php

namespace rsavinkov\Weather\Integration\Prediction\Dummy;

use DateTime;
use DateTimeInterface;
use rsavinkov\Weather\DTO\PredictionData;
use rsavinkov\Weather\Integration\Prediction\PredictionProviderInterface;

class JsonPredictionProvider implements PredictionProviderInterface
{
    private const PARTNER_NAME = 'Json partner';

    public function getPartnerName(): string
    {
        return self::PARTNER_NAME;
    }

    public function getPredictionData(DateTimeInterface $dateTime): PredictionData
    {
        $rawData = file_get_contents(__DIR__.'/data/temps.json');
        $rawData = str_replace('20180112', $dateTime->format('Ymd'), $rawData); // date hack

        return new PredictionData(
            $rawData,
            PredictionData::TYPE_JSON,
            $this->getPartnerName(),
            new DateTime()
        );
    }
}
