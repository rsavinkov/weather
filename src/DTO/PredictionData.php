<?php

namespace rsavinkov\Weather\DTO;

use DateTimeInterface;

class PredictionData
{
    public const TYPE_CSV = 'csv';
    public const TYPE_XML = 'xml';
    public const TYPE_JSON = 'json';

    private $rawData;
    private $type;
    private $partner;
    private $updatedAt;

    public function __construct(
        string $rawData,
        string $type,
        string $partner,
        DateTimeInterface $updatedAt
    ) {
        $this->rawData = $rawData;
        $this->type = $type;
        $this->partner = $partner;
        $this->updatedAt = $updatedAt;
    }

    public function getRawData(): string
    {
        return $this->rawData;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getPartner()
    {
        return $this->partner;
    }

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }
}
