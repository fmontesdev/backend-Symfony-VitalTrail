<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250319133408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE suscriptions_id_suscription_seq CASCADE');
        $this->addSql('ALTER TABLE suscriptions DROP CONSTRAINT fk_1f186e0e6b3ca4b');
        $this->addSql('DROP TABLE suscriptions');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE suscriptions_id_suscription_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE suscriptions (id_suscription BIGSERIAL NOT NULL, id_user UUID DEFAULT NULL, id_plan BIGINT NOT NULL, id_payment BIGINT NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, is_active BOOLEAN DEFAULT true NOT NULL, create_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, update_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id_suscription))');
        $this->addSql('CREATE INDEX idx_1f186e0e6b3ca4b ON suscriptions (id_user)');
        $this->addSql('COMMENT ON COLUMN suscriptions.id_user IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE suscriptions ADD CONSTRAINT fk_1f186e0e6b3ca4b FOREIGN KEY (id_user) REFERENCES users (id_user) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
