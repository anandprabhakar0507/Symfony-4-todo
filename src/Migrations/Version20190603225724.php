<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190603225724 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE citizin (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE citizin_city (citizin_id INT NOT NULL, city_id INT NOT NULL, INDEX IDX_A7FEAD4163CCD12F (citizin_id), INDEX IDX_A7FEAD418BAC62AF (city_id), PRIMARY KEY(citizin_id, city_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE citizen (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE citizin_city ADD CONSTRAINT FK_A7FEAD4163CCD12F FOREIGN KEY (citizin_id) REFERENCES citizin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE citizin_city ADD CONSTRAINT FK_A7FEAD418BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE todo CHANGE created_data created_data DATETIME DEFAULT \'1970-01-02\' NOT NULL, CHANGE date_due date_due DATETIME DEFAULT \'1970-01-02\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE citizin_city DROP FOREIGN KEY FK_A7FEAD4163CCD12F');
        $this->addSql('ALTER TABLE citizin_city DROP FOREIGN KEY FK_A7FEAD418BAC62AF');
        $this->addSql('DROP TABLE citizin');
        $this->addSql('DROP TABLE citizin_city');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE citizen');
        $this->addSql('ALTER TABLE todo CHANGE created_data created_data DATETIME DEFAULT \'1970-01-02 00:00:00\' NOT NULL, CHANGE date_due date_due DATETIME DEFAULT \'1970-01-02 00:00:00\' NOT NULL');
    }
}
