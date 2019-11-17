<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20191117161030 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add weather_prediction table';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql(
            'CREATE TABLE weather_prediction (
                id SERIAL, 
                partner VARCHAR(255) NOT NULL, 
                city VARCHAR(255) NOT NULL, 
                predictions_date_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, 
                celsius_temperature INT NOT NULL, 
                updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
                PRIMARY KEY(id)
            )'
        );
        $this->addSql('CREATE UNIQUE INDEX weather_prediction__partner_city_datetime__uniq ON weather_prediction (partner, city, predictions_date_time)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP INDEX weather_prediction__partner_city_datetime__uniq');
        $this->addSql('DROP TABLE IF EXISTS weather_prediction');
    }
}
