<?php

namespace rsavinkov\Weather\DTO\Api\Weather;

class Response
{
    public $predictions;

    public function __construct(Prediction ...$predictions)
    {
        $this->predictions = $predictions;
    }

    public function addPrediction(Prediction $prediction): self
    {
        $this->predictions[] = $prediction;

        return $this;
    }
}
