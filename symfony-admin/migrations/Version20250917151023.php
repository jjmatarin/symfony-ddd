<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250917151023 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id CHAR(26) NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, status VARCHAR(10) NOT NULL, active_license_version INT NOT NULL, active_license_type VARCHAR(10) NOT NULL, active_license_product_id CHAR(26) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN client.id IS \'(DC2Type:string)\'');
        $this->addSql('COMMENT ON COLUMN client.active_license_product_id IS \'(DC2Type:string)\'');
        $this->addSql('CREATE TABLE license (version INT NOT NULL, client_id CHAR(26) NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, product_id CHAR(26) NOT NULL, type VARCHAR(10) NOT NULL, PRIMARY KEY(version, client_id))');
        $this->addSql('CREATE INDEX IDX_5768F41919EB6921 ON license (client_id)');
        $this->addSql('COMMENT ON COLUMN license.client_id IS \'(DC2Type:string)\'');
        $this->addSql('COMMENT ON COLUMN license.product_id IS \'(DC2Type:string)\'');
        $this->addSql('ALTER TABLE license ADD CONSTRAINT FK_5768F41919EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product ALTER id TYPE CHAR(26)');
        $this->addSql('ALTER TABLE product ALTER id TYPE CHAR(26)');
        $this->addSql('COMMENT ON COLUMN product.id IS \'(DC2Type:string)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE license DROP CONSTRAINT FK_5768F41919EB6921');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE license');
        $this->addSql('ALTER TABLE product ALTER id TYPE CHAR(26)');
        $this->addSql('COMMENT ON COLUMN product.id IS NULL');
    }
}
