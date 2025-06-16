<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250614132800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE energy_intensity_per_gdp (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, year INTEGER NOT NULL, intensity_change_percent DOUBLE PRECISION DEFAULT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE renewable_energy_share (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, year INTEGER NOT NULL, total DOUBLE PRECISION DEFAULT NULL, heat_cooling_industry DOUBLE PRECISION DEFAULT NULL, electricity DOUBLE PRECISION DEFAULT NULL, transport DOUBLE PRECISION DEFAULT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE renewable_energy_twh (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, year INTEGER NOT NULL, biofuels DOUBLE PRECISION DEFAULT NULL, hydropower DOUBLE PRECISION DEFAULT NULL, wind_power DOUBLE PRECISION DEFAULT NULL, heat_pumps DOUBLE PRECISION DEFAULT NULL, solar_energy DOUBLE PRECISION DEFAULT NULL, total DOUBLE PRECISION DEFAULT NULL, statistical_transfer DOUBLE PRECISION DEFAULT NULL, target_calculation DOUBLE PRECISION DEFAULT NULL, total_energy_use DOUBLE PRECISION DEFAULT NULL)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE energy_intensity_per_gdp
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE renewable_energy_share
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE renewable_energy_twh
        SQL);
    }
}
