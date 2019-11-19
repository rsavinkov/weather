<?php

namespace rsavinkov\Weather\DTO\Api\Weather;

use DateTimeInterface;

class Prediction
{
    public $city;
    public $predictionsDateTime;
    public $scale;
    public $temperature;

    public function __construct(
        string $city,
        string $predictionsDateTime,
        string $scale,
        int $temperature
    ) {
        $this->city = $city;
        $this->predictionsDateTime = $predictionsDateTime;
        $this->scale = $scale;
        $this->temperature = $temperature;
    }
}
