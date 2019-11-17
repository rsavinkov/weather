<?php

namespace rsavinkov\Weather\Repository;

use rsavinkov\Weather\DTO\Prediction;
use rsavinkov\Weather\Entity\WeatherPrediction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

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
}
