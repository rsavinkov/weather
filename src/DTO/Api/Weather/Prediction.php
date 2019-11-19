<?php

namespace rsavinkov\Weather\DTO\Api\Weather;

use DateTimeInterface;

class Prediction
{
    public $city;
    public $predictionsDateTime;
    public $scale;
    public $temperature;
    public $updatedAt;

    public function __construct(
        string $city,
        string $predictionsDateTime,
        string $scale,
        int $temperature,
        int $updatedAt
    ) {
        $this->city = $city;
        $this->predictionsDateTime = $predictionsDateTime;
        $this->scale = $scale;
        $this->temperature = $temperature;
        $this->updatedAt = $updatedAt;
    }
}
