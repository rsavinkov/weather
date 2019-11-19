<?php

namespace rsavinkov\Weather\DTO;

use DateTimeInterface;

class AveragePrediction
{
    public $city;
    public $predictionsDateTime;
    public $celsiusTemperature;
    public $updatedAt;

    public function __construct(
        string $city,
        DateTimeInterface $predictionsDateTime,
        int $celsiusTemperature,
        DateTimeInterface $updatedAt
    ) {
        $this->city = $city;
        $this->predictionsDateTime = $predictionsDateTime;
        $this->celsiusTemperature = $celsiusTemperature;
        $this->updatedAt = $updatedAt;
    }
}
