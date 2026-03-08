<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250322065924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscriptions ADD payment_method_id VARCHAR(64) DEFAULT NULL');
        $this->addSql('ALTER TABLE subscriptions ADD payment_method_type VARCHAR(32) DEFAULT NULL');
        $this->addSql('ALTER TABLE subscriptions ADD card_brand VARCHAR(32) DEFAULT NULL');
        $this->addSql('ALTER TABLE subscriptions ADD card_last4 VARCHAR(4) DEFAULT NULL');
        $this->addSql('ALTER TABLE subscriptions ADD card_exp_month INT DEFAULT NULL');
        $this->addSql('ALTER TABLE subscriptions ADD card_exp_year INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE subscriptions DROP payment_method_id');
        $this->addSql('ALTER TABLE subscriptions DROP payment_method_type');
        $this->addSql('ALTER TABLE subscriptions DROP card_brand');
        $this->addSql('ALTER TABLE subscriptions DROP card_last4');
        $this->addSql('ALTER TABLE subscriptions DROP card_exp_month');
        $this->addSql('ALTER TABLE subscriptions DROP card_exp_year');
    }
}
