<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250925132844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE process (id SERIAL NOT NULL, client_id VARCHAR(126) NOT NULL, current_place VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE space (id SERIAL NOT NULL, client_id VARCHAR(126) NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE student (id SERIAL NOT NULL, space_id INT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B723AF3323575340 ON student (space_id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF3323575340 FOREIGN KEY (space_id) REFERENCES space (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE student DROP CONSTRAINT FK_B723AF3323575340');
        $this->addSql('DROP TABLE process');
        $this->addSql('DROP TABLE space');
        $this->addSql('DROP TABLE student');
    }
}
