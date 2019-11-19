<?php

namespace rsavinkov\Weather\Repository;

use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use rsavinkov\Weather\DTO\AveragePrediction;
use rsavinkov\Weather\DTO\Prediction;
use rsavinkov\Weather\Entity\WeatherPrediction;
use rsavinkov\Weather\Service\ScaleConverter\CelsiusConverter;

/**
 * @method WeatherPrediction|null find($id, $lockMode = null, $lockVersion = null)
 * @method WeatherPrediction|null findOneBy(array $criteria, array $orderBy = null)
 * @method WeatherPrediction[]    findAll()
 * @method WeatherPrediction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeatherPredictionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WeatherPrediction::class);
    }

    public function updateFromPredictions(Prediction ...$predictions)
    {
        $preparedStatement = $this->getEntityManager()->getConnection()->prepare(
<<<EOS
INSERT INTO weather_prediction(partner, city, predictions_date_time, celsius_temperature, updated_at)
VALUES(:partner, :city, :predictions_date_time, :celsius_temperature, :updated_at)
ON CONFLICT (partner, city, predictions_date_time)
DO UPDATE SET 
celsius_temperature = :celsius_temperature,
updated_at = :updated_at
EOS
        );

        foreach ($predictions as $prediction) {
            $preparedStatement->execute([
                'partner' => $prediction->getPartner(),
                'city' => $prediction->getCity(),
                'predictions_date_time' => $prediction->getPredictionsDateTime()->format("Y-m-d H:i:s"),
                'celsius_temperature' => $prediction->getCelsiusTemperature(),
                'updated_at' => $prediction->getUpdatedAt()->format("Y-m-d H:i:s")
            ]);
        }
    }

    /**
     * @param string $city
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @return AveragePrediction[]
     */
    public function getAvgPredictionsByCity(string $city, DateTime $startDate, DateTime $endDate): array
    {
        $arrResult = $this->createQueryBuilder('wp')
            ->select('wp.city, wp.predictionsDateTime, AVG(wp.celsiusTemperature) as celsiusTemperature, max(wp.updatedAt) as updatedAt')
            ->andWhere('wp.city = :city')
            ->andWhere('wp.predictionsDateTime >= :startDate')
            ->andWhere('wp.predictionsDateTime < :endDate')
            ->setParameters([
                'city' => $city,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ])
            ->groupBy('wp.city')
            ->addGroupBy('wp.predictionsDateTime')
            ->orderBy('wp.city')
            ->addOrderBy('wp.predictionsDateTime')
            ->getQuery()->getArrayResult();

        return array_map(
            function (array $predictionData) {
                return new AveragePrediction(
                    $predictionData['city'],
                    $predictionData['predictionsDateTime'],
                    $predictionData['celsiusTemperature'],
                    DateTime::createFromFormat('Y-m-d H:i:s', $predictionData['updatedAt'])
                );
            },
            $arrResult
        );
    }
}
