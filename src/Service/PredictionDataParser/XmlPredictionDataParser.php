<?php

namespace rsavinkov\Weather\Service\PredictionDataParser;

use DateTime;
use rsavinkov\Weather\DTO\Prediction;
use rsavinkov\Weather\DTO\PredictionData;
use rsavinkov\Weather\Service\ScaleConverter\ScaleConverter;
use SimpleXMLElement;

class XmlPredictionDataParser implements SpecificPredictionDataParserInterface
{
    private $scaleConverter;

    public function __construct(ScaleConverter $scaleConverter)
    {
        $this->scaleConverter = $scaleConverter;
    }

    public function support(PredictionData $predictionData): bool
    {
        return $predictionData->getType() === PredictionData::TYPE_XML;
    }

    public function mapToPredictions(PredictionData $predictionData): array
    {
        $predictions = [];

        $predictionsElement = new SimpleXMLElement($predictionData->getRawData());
        foreach ($predictionsElement->prediction as $prediction) {
            $predictions[] = new Prediction(
                $predictionData->getPartner(),
                $predictionsElement->city,
                DateTime::createFromFormat('Ymd H:i', $predictionsElement->date . ' ' . $prediction->time),
                $this->scaleConverter->toCelsius(
                    $predictionsElement['scale'],
                    intval($prediction->value)
                ),
                $predictionData->getUpdatedAt()
            );
        }

        return $predictions;
    }
}
