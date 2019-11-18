<?php

namespace rsavinkov\Weather\DTO;

use DateTimeInterface;

class Prediction
{
    private $partner;
    private $city;
    private $predictionsDateTime;
    private $celsiusTemperature;
    private $updatedAt;

    public function __construct(
        string $partner,
        string $city,
        DateTimeInterface $predictionsDateTime,
        int $celsiusTemperature,
        DateTimeInterface $updatedAt
    ) {
        $this->partner = $partner;
        $this->city = $city;
        $this->predictionsDateTime = $predictionsDateTime;
        $this->celsiusTemperature = $celsiusTemperature;
        $this->updatedAt = $updatedAt;
    }

    public function getPartner(): string
    {
        return $this->partner;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getPredictionsDateTime(): DateTimeInterface
    {
        return $this->predictionsDateTime;
    }

    public function getCelsiusTemperature(): int
    {
        return $this->celsiusTemperature;
    }

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }
}
