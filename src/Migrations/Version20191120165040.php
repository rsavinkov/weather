<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191120165040 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Improve index';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP INDEX weather_prediction__partner_city_datetime__uniq');
        $this->addSql('CREATE UNIQUE INDEX weather_prediction__city_datetime_partner__uniq ON weather_prediction (city, predictions_date_time, partner)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP INDEX weather_prediction__city_datetime_partner__uniq');
        $this->addSql('CREATE UNIQUE INDEX weather_prediction__partner_city_datetime__uniq ON weather_prediction (partner, city, predictions_date_time)');
    }
}
