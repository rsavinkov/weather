<?php

namespace rsavinkov\Weather\Service\PredictionDataParser;

use DateTime;
use rsavinkov\Weather\DTO\Prediction;
use rsavinkov\Weather\DTO\PredictionData;
use rsavinkov\Weather\Service\ScaleConverter\ScaleConverter;

class CsvPredictionDataParser implements SpecificPredictionDataParserInterface
{
    private $scaleConverter;

    public function __construct(ScaleConverter $scaleConverter)
    {
        $this->scaleConverter = $scaleConverter;
    }

    public function support(PredictionData $predictionData): bool
    {
        return $predictionData->getType() === PredictionData::TYPE_CSV;
    }

    public function mapToPredictions(PredictionData $predictionData): array
    {
        $dataArray = $this->mapPredictionsDataToArray($predictionData);

        $predictions = [];
        foreach ($dataArray as $data) {
            $predictions[] = new Prediction(
                $predictionData->getPartner(),
                $data['city'],
                DateTime::createFromFormat('Ymd H:i', $data['date'] . ' ' . $data['prediction__time']),
                $this->scaleConverter->toCelsius(
                    $data['-scale'],
                    intval($data['prediction__value'])
                ),
                $predictionData->getUpdatedAt()
            );
        }

        return $predictions;
    }

    private function mapPredictionsDataToArray(PredictionData $predictionData): array
    {
        $rows = array_map(
            'str_getcsv',
            array_filter(explode("\n", $predictionData->getRawData()))
        );

        $dataArray = [];
        $headers = array_map(function ($title) {return trim($title, "﻿\"");}, $rows[0]);

        $currentValues = [];
        for($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];
            $data = [];
            foreach ($headers as $column => $title) {
                if (!empty($row[$column])) {
                    $currentValues[$column] = $row[$column];
                }
                $data[$title] = empty($row[$column]) ? $currentValues[$column] : $row[$column];
            }
            $dataArray[] = $data;
        }

        return $dataArray;
    }
}
