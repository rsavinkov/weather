<?php

namespace rsavinkov\Weather\Controller\Api\Weather;

use DateInterval;
use DateTime;
use rsavinkov\Weather\DTO\Error\ErrorResponse;
use rsavinkov\Weather\Repository\WeatherPredictionRepository;
use rsavinkov\Weather\Service\ScaleConverter\CelsiusConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    private $validator;

    private $weatherPredictionRepository;

    private $mapper;

    public function __construct(
        Validator $validator,
        WeatherPredictionRepository $weatherPredictionRepository,
        Mapper $mapper
    ) {
        $this->validator = $validator;
        $this->weatherPredictionRepository = $weatherPredictionRepository;
        $this->mapper = $mapper;
    }

    /**
     * @Route("/api/weather", methods={"GET"}))
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getWeatherAction(Request $request)
    {
        $city = $request->get('city');
        $date = $request->get('date')
            ? DateTime::createFromFormat('Y-m-d H:i:s', $request->get('date') . '00:00:00')
            : new DateTime('today');
        $scale = $request->get('scale') ?: CelsiusConverter::SCALE_NAME;

        $errorResponse = new ErrorResponse();
        $this->validator->validateCity($errorResponse, $city);
        $this->validator->validateDate($errorResponse, $date);
        $this->validator->validateScale($errorResponse, $scale);

        if ($errorResponse->hasErrors()) {
            return $this->json($errorResponse, HttpResponse::HTTP_BAD_REQUEST);
        }

        $averagePredictions = $this->weatherPredictionRepository->getAvgPredictionsByCity(
            $city,
            $date,
            (clone $date)->add(new DateInterval('P1D'))
        );


        return $this->json(
            $this->mapper->mapAveragePredictionsToResponse($scale, ...$averagePredictions)
        );
    }
}
