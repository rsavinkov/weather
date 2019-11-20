<?php

namespace rsavinkov\Weather\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="rsavinkov\Weather\Repository\WeatherPredictionRepository")
 * @ORM\Table(uniqueConstraints={
 *     @ORM\UniqueConstraint(
 *         name="weather_prediction__city_datetime_partner__uniq",
 *         columns={"city", "predictions_date_time", "partner"}
 *     )
 * })
 */
class WeatherPrediction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $partner;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="datetime")
     */
    private $predictionsDateTime;

    /**
     * @ORM\Column(type="integer")
     */
    private $celsiusTemperature;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPartner(): ?string
    {
        return $this->partner;
    }

    public function setPartner(string $partner): self
    {
        $this->partner = $partner;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPredictionsDateTime(): ?DateTimeInterface
    {
        return $this->predictionsDateTime;
    }

    public function setPredictionsDateTime(DateTimeInterface $predictionsDateTime): self
    {
        $this->predictionsDateTime = $predictionsDateTime;

        return $this;
    }

    public function getCelsiusTemperature(): ?int
    {
        return $this->celsiusTemperature;
    }

    public function setCelsiusTemperature(int $celsiusTemperature): self
    {
        $this->celsiusTemperature = $celsiusTemperature;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
