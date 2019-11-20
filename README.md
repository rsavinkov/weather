# Weather

Example of application, which regularly get weather predictions from different external providers, and return to users 
average value.

You can try it here: http://178.62.245.179/
## Application architecture

### Technologies
I use PHP 7.2, Postgres 11, Symfony 4.3, Docker for development environment, and DigitalOcean's droplet with ubuntu on 
production

### Main idea

We get data from our partners via API. And we've set a threshold of 1 minute to invalidate this data.
It's possible to request our partners during each request to our API and keep a cache of the response in Memcache for 1 
minute. But in this case, the first request, when we don have any cache, can take a lot of time (especially, if we will 
have more partners). That's why I decided to udpate a partner's data to our database by using a command and do it each 
minute by a cronjob.

### Important parts of code:
- `src/Integration/Prediction` - Dummy integrations to weather predictions from partner for specific date
- `src/DTO/PredictionData.php` - Data Transfer Object (DTO) for keeping data from partner in original format
- `src/DTO/Prediction.php` - DTO for kepeng data from partner in common useful format
- `src/Service/PredictionDataParser/PredictionDataParser.php` - Service for parse PredictionData to array of Predicitons. 
It's easy to add parser for new format - you just need to implement `SpecificPredictionDataParserInterface` and register 
it in `PredictionDataParser`
- `src/Service/ScaleConverter/ScaleConverter.php` - service for convert different temperature scales to celsius and back.
It's easy to add converter for new format - you just need to implement `SpecificScaleConverterInterface` and register it
in `ScaleConverter`
- `src/Entity/WeatherPrediction.php` - Entity for saving predicitons to database. I keep temperature in single scale 
(celsius), because I think it makes code more easy and clear.
- `src/Service/PredictionsActualizer.php` - Service for updating predictions in database from provider's API
- `src/Repository/WeatherPredictionRepository.php` - AveragePredicitons caclulate on database side in celsius scale, you 
can see it in repository
- `src/Controller/Api/Weather` - Endpoint classes, like Controller, Validator, Mapper. Mapper can convert temperature to 
any available scale in `ScaleConverter`
- `public/index.html` - place for simple SPA

### What I can do better 
#### (But didn't, because I want to send you assignment ASAP)
- Create tests
- Install nelmio-bundle and create auto-documentation
- Create simple frontend on Vue.js or at least JQuery (`public/index.html`)

## Dev-environment

### Installation

1) `docker-compose up -d`
2) `docker-compose exec php-fpm composer install`
3) `docker-compose exec php-fpm cp /application/.env.dist /application/.env`
4) `docker-compose exec php-fpm php bin/console doctrine:migtrations:migrate`
5) Check link https:/127.0.0.1:8080

## Documentation

###Command
#### weather:predictions:collect
Usage:
`php bin/console weather:predictions:collect [<upcomingDaysNumber>]`

Arguments:
  `upcomingDaysNumber` For what number of upcoming days do you need to update a weather predictions? [default: 10]

### Endpoint
#### GET /api/weather
`GET /api/weather?city=Amsterdam&date=2019-11-29&scale=fahrenheit`

Parameters:
```
city=Amsterdam // required
date=2019-11-29 // optional (default: current day) date for predicions in 'Y-m-d' format. It isn't be possible to search dates greater than the current day + 10 days.
scale=fahrenheit // optional (default: 'celsius'), scale like 'celsius', 'fahrenheit'
```
Example of response, if everything is fine: 200 OK
```
{
    predictions: [
        {
            city: "Amsterdam",
            predictionsDateTime: "2019-11-29 00:00:00",
            scale: "fahrenheit",
            temperature: 37,
            updatedAt: 1574271663
        },
        ...
    ]
}
```
Example of response, if request is incorrect: 400 Bad Request
```
{
    success: false,
    errors: [
        {
            propertyPath: "city",
            message: "Field can't be empty."
        },
        {
            propertyPath: "day",
            message: "Predictions are available only for today or upcoming 10 days"
        },
        {
            propertyPath: "scale",
            message: "Unsupported scale: Réaumur"
        }
    ]
}
```
