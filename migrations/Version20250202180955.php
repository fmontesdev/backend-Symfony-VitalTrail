<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250202180955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories_routes (id_category BIGSERIAL NOT NULL, id_route BIGINT DEFAULT NULL, title VARCHAR(128) NOT NULL, img_category VARCHAR(255) NOT NULL, PRIMARY KEY(id_category))');
        $this->addSql('CREATE INDEX IDX_3ABCFC8BEC416149 ON categories_routes (id_route)');
        $this->addSql('ALTER TABLE categories_routes ADD CONSTRAINT FK_3ABCFC8BEC416149 FOREIGN KEY (id_route) REFERENCES routes (id_route) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE categories_routes DROP CONSTRAINT FK_3ABCFC8BEC416149');
        $this->addSql('DROP TABLE categories_routes');
    }
}
