<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190603234220 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP todo, CHANGE username name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE todo ADD user_id INT DEFAULT NULL, DROP user, CHANGE created_data created_data DATETIME DEFAULT \'1970-01-02\' NOT NULL, CHANGE date_due date_due DATETIME DEFAULT \'1970-01-02\' NOT NULL');
        $this->addSql('ALTER TABLE todo ADD CONSTRAINT FK_5A0EB6A0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5A0EB6A0A76ED395 ON todo (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE todo DROP FOREIGN KEY FK_5A0EB6A0A76ED395');
        $this->addSql('DROP INDEX UNIQ_5A0EB6A0A76ED395 ON todo');
        $this->addSql('ALTER TABLE todo ADD user VARCHAR(255) DEFAULT \'0\' NOT NULL COLLATE utf8mb4_unicode_ci, DROP user_id, CHANGE created_data created_data DATETIME DEFAULT \'1970-01-02 00:00:00\' NOT NULL, CHANGE date_due date_due DATETIME DEFAULT \'1970-01-02 00:00:00\' NOT NULL');
        $this->addSql('ALTER TABLE user ADD todo VARCHAR(255) DEFAULT \'0\' NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE name username VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
