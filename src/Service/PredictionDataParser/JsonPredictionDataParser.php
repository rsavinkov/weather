<?php


namespace rsavinkov\Weather\Service\PredictionDataParser;

use DateTime;
use rsavinkov\Weather\DTO\Prediction;
use rsavinkov\Weather\DTO\PredictionData;
use rsavinkov\Weather\Service\ScaleConverter\ScaleConverter;

class JsonPredictionDataParser implements SpecificPredictionDataParserInterface
{
    private $scaleConverter;

    public function __construct(ScaleConverter $scaleConverter)
    {
        $this->scaleConverter = $scaleConverter;
    }

    public function support(PredictionData $predictionData): bool
    {
        return $predictionData->getType() === PredictionData::TYPE_JSON;
    }

    public function mapToPredictions(PredictionData $predictionData): array
    {
        $dataArray = json_decode($predictionData->getRawData(), true);

        if (empty($dataArray['predictions']) || empty($dataArray['predictions']['prediction'])) {
            return [];
        }

        $predictions = [];
        foreach ($dataArray['predictions']['prediction'] as $prediction) {
            $predictions[] = new Prediction(
                $predictionData->getPartner(),
                $dataArray['predictions']['city'],
                DateTime::createFromFormat('Ymd H:i', $dataArray['predictions']['date'] . ' ' . $prediction['time']),
                $this->scaleConverter->toCelsius(
                    $dataArray['predictions']['-scale'],
                    intval($prediction['value'])
                ),
                $predictionData->getUpdatedAt()
            );
        }

        return $predictions;
    }
}
