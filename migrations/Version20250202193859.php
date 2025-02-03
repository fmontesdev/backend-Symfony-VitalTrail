<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250202193859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories_routes DROP CONSTRAINT fk_3abcfc8bec416149');
        $this->addSql('DROP INDEX idx_3abcfc8bec416149');
        $this->addSql('ALTER TABLE categories_routes DROP id_route');
        $this->addSql('ALTER TABLE routes ADD id_category BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE routes ADD CONSTRAINT FK_32D5C2B35697F554 FOREIGN KEY (id_category) REFERENCES categories_routes (id_category) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_32D5C2B35697F554 ON routes (id_category)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE categories_routes ADD id_route BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE categories_routes ADD CONSTRAINT fk_3abcfc8bec416149 FOREIGN KEY (id_route) REFERENCES routes (id_route) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_3abcfc8bec416149 ON categories_routes (id_route)');
        $this->addSql('ALTER TABLE routes DROP CONSTRAINT FK_32D5C2B35697F554');
        $this->addSql('DROP INDEX IDX_32D5C2B35697F554');
        $this->addSql('ALTER TABLE routes DROP id_category');
    }
}
