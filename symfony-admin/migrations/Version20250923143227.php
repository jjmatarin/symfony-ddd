<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250923143227 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stored_event (aggregate_id VARCHAR(255) NOT NULL, playhead INT NOT NULL, aggregate_type VARCHAR(255) NOT NULL, event_type VARCHAR(255) NOT NULL, payload JSON NOT NULL, recorded_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(aggregate_id, playhead))');
        $this->addSql('COMMENT ON COLUMN stored_event.recorded_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE stored_event');
    }
}
