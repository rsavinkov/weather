<?php

namespace rsavinkov\Weather\Service\ScaleConverter;

use InvalidArgumentException;

class ScaleConverter
{
    private $converters;

    public function __construct(SpecificScaleConverterInterface ...$converters)
    {
        $this->converters = $converters;
    }

    public function support(string $scale): bool
    {
        foreach ($this->converters as $converter) {
            if($converter->support($scale)) {
                return true;
            }
        }

        return false;
    }

    public function toCelsius(string $scale, int $temperature): int
    {
        foreach ($this->converters as $converter) {
            if($converter->support($scale)) {
                return $converter->toCelsius($temperature);
            }
        }

        throw new InvalidArgumentException('Unsupported scale: ' . $scale);
    }

    public function fromCelsius(string $scale, int $temperature): int
    {
        foreach ($this->converters as $converter) {
            if($converter->support($scale)) {
                return $converter->fromCelsius($temperature);
            }
        }

        throw new InvalidArgumentException('Unsupported scale: ' . $scale);
    }
}
