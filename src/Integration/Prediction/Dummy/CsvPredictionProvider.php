<?php

namespace rsavinkov\Weather\Integration\Prediction\Dummy;

use DateTime;
use DateTimeInterface;
use rsavinkov\Weather\DTO\PredictionData;
use rsavinkov\Weather\Integration\Prediction\PredictionProviderInterface;

class CsvPredictionProvider implements PredictionProviderInterface
{
    private const PARTNER_NAME = 'CSV partner';

    public function getPartnerName(): string
    {
        return self::PARTNER_NAME;
    }

    public function getPredictionData(DateTimeInterface $dateTime): PredictionData
    {
        $rawData = file_get_contents(__DIR__.'/data/temps.csv');
        $rawData = str_replace('20180112', $dateTime->format('Ymd'), $rawData); // date hack

        return new PredictionData(
            $rawData,
            PredictionData::TYPE_CSV,
            $this->getPartnerName(),
            new DateTime()
        );
    }
}
