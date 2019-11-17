<?php

namespace rsavinkov\Weather\Service\ScaleConverter;

interface SpecificScaleConverterInterface
{
    public function support(string $scale): bool;

    public function toCelsius(int $temperature): int;

    public function fromCelsius(int $temperature): int;
}
