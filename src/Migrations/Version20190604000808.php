<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190604000808 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE citizin_city DROP FOREIGN KEY FK_A7FEAD4163CCD12F');
        $this->addSql('CREATE TABLE citizen_city (citizen_id INT NOT NULL, city_id INT NOT NULL, INDEX IDX_605EC735A63C3C2E (citizen_id), INDEX IDX_605EC7358BAC62AF (city_id), PRIMARY KEY(citizen_id, city_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE citizen_city ADD CONSTRAINT FK_605EC735A63C3C2E FOREIGN KEY (citizen_id) REFERENCES citizen (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE citizen_city ADD CONSTRAINT FK_605EC7358BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE citizin');
        $this->addSql('DROP TABLE citizin_city');
        $this->addSql('ALTER TABLE todo CHANGE created_data created_data DATETIME DEFAULT \'1970-01-02\' NOT NULL, CHANGE date_due date_due DATETIME DEFAULT \'1970-01-02\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE citizin (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE citizin_city (citizin_id INT NOT NULL, city_id INT NOT NULL, INDEX IDX_A7FEAD4163CCD12F (citizin_id), INDEX IDX_A7FEAD418BAC62AF (city_id), PRIMARY KEY(citizin_id, city_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE citizin_city ADD CONSTRAINT FK_A7FEAD4163CCD12F FOREIGN KEY (citizin_id) REFERENCES citizin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE citizin_city ADD CONSTRAINT FK_A7FEAD418BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE citizen_city');
        $this->addSql('ALTER TABLE todo CHANGE created_data created_data DATETIME DEFAULT \'1970-01-02 00:00:00\' NOT NULL, CHANGE date_due date_due DATETIME DEFAULT \'1970-01-02 00:00:00\' NOT NULL');
    }
}
