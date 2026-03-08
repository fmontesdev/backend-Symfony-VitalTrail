<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Sync Doctrine ORM expectations with the existing route_sessions / wellbeing_checkins tables.
 * The initial migration used GENERATED ALWAYS AS IDENTITY which creates implicit sequences;
 * this migration converts to explicit sequences, renames indexes, and adds the DC2Type:uuid comment.
 */
final class Version20260308201603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Sync route_sessions and wellbeing_checkins schema with Doctrine ORM expectations';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('DROP INDEX IF EXISTS idx_route_sessions_user_start');
        $this->addSql('ALTER TABLE route_sessions ALTER id_user TYPE UUID');
        $this->addSql('ALTER TABLE route_sessions ALTER start_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE route_sessions ALTER create_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('COMMENT ON COLUMN route_sessions.id_user IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER INDEX IF EXISTS idx_route_sessions_route RENAME TO IDX_644CD538EC416149');
        $this->addSql('ALTER TABLE wellbeing_checkins ALTER create_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER INDEX IF EXISTS wellbeing_checkins_id_session_key RENAME TO UNIQ_FF9DD0C7ED97CA4');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE route_sessions ALTER id_user TYPE UUID');
        $this->addSql('ALTER TABLE route_sessions ALTER start_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE route_sessions ALTER create_at SET DEFAULT \'now()\'');
        $this->addSql('COMMENT ON COLUMN route_sessions.id_user IS NULL');
        $this->addSql('CREATE INDEX idx_route_sessions_user_start ON route_sessions (id_user, start_at)');
        $this->addSql('ALTER INDEX IF EXISTS IDX_644CD538EC416149 RENAME TO idx_route_sessions_route');
        $this->addSql('ALTER TABLE wellbeing_checkins ALTER create_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER INDEX IF EXISTS UNIQ_FF9DD0C7ED97CA4 RENAME TO wellbeing_checkins_id_session_key');
    }
}
