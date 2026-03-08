<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260308120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create route_sessions and wellbeing_checkins tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE route_sessions (
            id_session BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
            id_user UUID NOT NULL REFERENCES users(id_user) ON DELETE CASCADE,
            id_route BIGINT NOT NULL REFERENCES routes(id_route) ON DELETE CASCADE,
            start_at TIMESTAMP NOT NULL DEFAULT now(),
            end_at TIMESTAMP NULL,
            create_at TIMESTAMP NOT NULL DEFAULT now()
        )');
        $this->addSql('CREATE INDEX idx_route_sessions_user_start ON route_sessions (id_user, start_at)');
        $this->addSql('CREATE INDEX idx_route_sessions_route ON route_sessions (id_route)');
        $this->addSql('CREATE TABLE wellbeing_checkins (
            id_checkin BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
            id_session BIGINT NOT NULL UNIQUE REFERENCES route_sessions(id_session) ON DELETE CASCADE,
            energy SMALLINT NOT NULL CHECK (energy BETWEEN 1 AND 5),
            stress SMALLINT NOT NULL CHECK (stress BETWEEN 1 AND 5),
            mood SMALLINT NOT NULL CHECK (mood BETWEEN 1 AND 5),
            notes VARCHAR(255) NULL,
            create_at TIMESTAMP NOT NULL DEFAULT now()
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS wellbeing_checkins');
        $this->addSql('DROP TABLE IF EXISTS route_sessions');
    }
}
