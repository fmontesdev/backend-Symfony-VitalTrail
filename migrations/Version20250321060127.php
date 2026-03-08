<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250321060127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clients ADD payment_method_id VARCHAR(64) DEFAULT NULL');
        $this->addSql('ALTER TABLE clients DROP is_premium');
        $this->addSql('ALTER TABLE users ADD is_premium BOOLEAN DEFAULT false NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE clients ADD is_premium BOOLEAN DEFAULT false NOT NULL');
        $this->addSql('ALTER TABLE clients DROP payment_method_id');
        $this->addSql('ALTER TABLE users DROP is_premium');
    }
}
