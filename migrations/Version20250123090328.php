<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250123090328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE refresh_tokens_id_refresh_seq CASCADE');
        $this->addSql('DROP INDEX uniq_9bace7e1f85e0677');
        $this->addSql('ALTER TABLE refresh_tokens DROP CONSTRAINT refresh_tokens_pkey');
        $this->addSql('ALTER TABLE refresh_tokens ADD id SERIAL NOT NULL');
        $this->addSql('ALTER TABLE refresh_tokens DROP id_refresh');
        $this->addSql('ALTER TABLE refresh_tokens ALTER username TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE refresh_tokens ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE refresh_tokens_id_refresh_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP INDEX refresh_tokens_pkey');
        $this->addSql('ALTER TABLE refresh_tokens ADD id_refresh BIGSERIAL NOT NULL');
        $this->addSql('ALTER TABLE refresh_tokens DROP id');
        $this->addSql('ALTER TABLE refresh_tokens ALTER username TYPE VARCHAR(32)');
        $this->addSql('CREATE UNIQUE INDEX uniq_9bace7e1f85e0677 ON refresh_tokens (username)');
        $this->addSql('ALTER TABLE refresh_tokens ADD PRIMARY KEY (id_refresh)');
    }
}
