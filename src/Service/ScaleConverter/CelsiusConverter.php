<?php

namespace rsavinkov\Weather\Service\ScaleConverter;

class CelsiusConverter implements SpecificScaleConverterInterface
{
    const SCALE_NAME = 'celsius';

    public function support(string $scale): bool
    {
        return self::SCALE_NAME === strtolower($scale);
    }

    public function toCelsius(int $temperature): int
    {
        return $temperature;
    }

    public function fromCelsius(int $temperature): int
    {
        return $temperature;
    }
}
