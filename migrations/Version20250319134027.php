<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250319134027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE subscriptions (id BIGSERIAL NOT NULL, id_user UUID NOT NULL, subscription_id VARCHAR(64) NOT NULL, subscription_type VARCHAR(32) NOT NULL, billing_interval VARCHAR(32) NOT NULL, customer_id VARCHAR(64) NOT NULL, product_id VARCHAR(64) NOT NULL, product_name VARCHAR(255) NOT NULL, price_id VARCHAR(64) NOT NULL, current_period_start INT NOT NULL, current_period_end INT NOT NULL, cancel_at_period_end BOOLEAN DEFAULT false NOT NULL, cancellation_reason VARCHAR(255) NOT NULL, status VARCHAR(32) NOT NULL, last_event_type VARCHAR(64) NOT NULL, create_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, update_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4778A019A1887DC ON subscriptions (subscription_id)');
        $this->addSql('CREATE INDEX IDX_4778A016B3CA4B ON subscriptions (id_user)');
        $this->addSql('COMMENT ON COLUMN subscriptions.id_user IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE subscriptions ADD CONSTRAINT FK_4778A016B3CA4B FOREIGN KEY (id_user) REFERENCES users (id_user) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE subscriptions DROP CONSTRAINT FK_4778A016B3CA4B');
        $this->addSql('DROP TABLE subscriptions');
    }
}
