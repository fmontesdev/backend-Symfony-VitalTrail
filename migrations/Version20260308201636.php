<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Convert GENERATED ALWAYS AS IDENTITY columns to regular sequences so Doctrine ORM
 * can manage them with its standard PostgreSQL identity_generation_preferences.
 */
final class Version20260308201636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Convert IDENTITY columns to sequence-backed defaults for Doctrine ORM compatibility';
    }

    public function up(Schema $schema): void
    {
        // Drop GENERATED ALWAYS AS IDENTITY and attach the implicit sequence as DEFAULT nextval()
        $this->addSql('ALTER TABLE route_sessions ALTER COLUMN id_session DROP IDENTITY IF EXISTS');
        $this->addSql('CREATE SEQUENCE IF NOT EXISTS route_sessions_id_session_seq OWNED BY route_sessions.id_session');
        $this->addSql('SELECT setval(\'route_sessions_id_session_seq\', COALESCE((SELECT MAX(id_session) FROM route_sessions), 1))');
        $this->addSql('ALTER TABLE route_sessions ALTER id_session SET DEFAULT nextval(\'route_sessions_id_session_seq\')');

        $this->addSql('ALTER TABLE wellbeing_checkins ALTER COLUMN id_checkin DROP IDENTITY IF EXISTS');
        $this->addSql('CREATE SEQUENCE IF NOT EXISTS wellbeing_checkins_id_checkin_seq OWNED BY wellbeing_checkins.id_checkin');
        $this->addSql('SELECT setval(\'wellbeing_checkins_id_checkin_seq\', COALESCE((SELECT MAX(id_checkin) FROM wellbeing_checkins), 1))');
        $this->addSql('ALTER TABLE wellbeing_checkins ALTER id_checkin SET DEFAULT nextval(\'wellbeing_checkins_id_checkin_seq\')');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE route_sessions ALTER id_session DROP DEFAULT');
        $this->addSql('ALTER TABLE route_sessions ALTER COLUMN id_session ADD GENERATED ALWAYS AS IDENTITY');
        $this->addSql('ALTER TABLE wellbeing_checkins ALTER id_checkin DROP DEFAULT');
        $this->addSql('ALTER TABLE wellbeing_checkins ALTER COLUMN id_checkin ADD GENERATED ALWAYS AS IDENTITY');
    }
}
