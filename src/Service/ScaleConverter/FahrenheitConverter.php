<?php

namespace rsavinkov\Weather\Service\ScaleConverter;

class FahrenheitConverter implements SpecificScaleConverterInterface
{
    const SCALE_NAME = 'fahrenheit';

    public function support(string $scale): bool
    {
        return self::SCALE_NAME === strtolower($scale);
    }

    public function toCelsius(int $temperature): int
    {
        return intval(($temperature - 32) * 5 / 9);
    }

    public function fromCelsius(int $temperature): int
    {
        return intval($temperature * 9 / 5) + 32;
    }
}
