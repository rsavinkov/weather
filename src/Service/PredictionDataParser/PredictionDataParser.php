<?php

namespace rsavinkov\Weather\Service\PredictionDataParser;

use InvalidArgumentException;
use rsavinkov\Weather\DTO\Prediction;
use rsavinkov\Weather\DTO\PredictionData;

class PredictionDataParser
{
    private $parsers;

    public function __construct(SpecificPredictionDataParserInterface ...$parsers)
    {
        $this->parsers = $parsers;
    }

    /**
     * @param PredictionData $predictionData
     * @return Prediction[]
     */
    public function mapToPredictions(PredictionData $predictionData): array
    {
        foreach ($this->parsers as $parser) {
            if ($parser->support($predictionData)) {
                return  $parser->mapToPredictions($predictionData);
            }
        }

        throw new InvalidArgumentException('Unsupported prediction data type: ' . $predictionData->getType());
    }
}
