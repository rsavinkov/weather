<?php

namespace rsavinkov\Weather\Controller\Api\Weather;

use DateTime;
use rsavinkov\Weather\DTO\Error\ErrorResponse;
use rsavinkov\Weather\Service\ScaleConverter\ScaleConverter;

class Validator
{
    private const MAX_PREDICTIONS_INTERVAL_IN_DAYS = 10;

    private $scaleConverter;

    public function __construct(ScaleConverter $scaleConverter)
    {
        $this->scaleConverter = $scaleConverter;
    }

    public function validateCity(ErrorResponse $errorResponse, $city)
    {
        if (empty($city)) {
            $errorResponse->addError('city', 'Field can\'t be empty.');
        }
    }

    public function validateDate(ErrorResponse $errorResponse, $date)
    {
        $today = new DateTime('today');
        $maxPredictionsDay = new DateTime('+' . self::MAX_PREDICTIONS_INTERVAL_IN_DAYS . ' days');
        if ($date === false) {
            $errorResponse->addError('date', 'Incorrect day format. "Y-m-d" is expecting.');
        } elseif ($date < $today || $date > $maxPredictionsDay) {
            $errorResponse->addError(
                'day',
                'Predictions are available only for today or upcoming ' . self::MAX_PREDICTIONS_INTERVAL_IN_DAYS . ' days'
            );
        }
    }

    public function validateScale(ErrorResponse $errorResponse, $scale)
    {
        if (!$this->scaleConverter->support($scale)) {
            $errorResponse->addError('scale', 'Unsupported scale: ' . $scale);
        }
    }
}
