<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Adds notifications system:
 * - notifications.type (VARCHAR 50)
 * - notifications.created_at changed to TIMESTAMP (immutable)
 * - notifications_users.is_read (BOOLEAN, default false)
 * - notifications_users.read_at (TIMESTAMP, nullable)
 */
final class Version20260413120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add type column to notifications, add is_read and read_at to notifications_users';
    }

    public function up(Schema $schema): void
    {
        // Agregar columna type a notifications
        $this->addSql('ALTER TABLE notifications ADD type VARCHAR(50) NOT NULL DEFAULT \'system\'');

        // Renombrar create_at -> created_at y cambiar tipo a TIMESTAMP immutable
        $this->addSql('ALTER TABLE notifications RENAME COLUMN create_at TO created_at');
        $this->addSql('ALTER TABLE notifications ALTER COLUMN created_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE notifications ALTER COLUMN created_at DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN notifications.created_at IS \'(DC2Type:datetime_immutable)\'');

        // Agregar columnas a notifications_users
        $this->addSql('ALTER TABLE notifications_users ADD is_read BOOLEAN NOT NULL DEFAULT false');
        $this->addSql('ALTER TABLE notifications_users ADD read_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE notifications DROP type');
        $this->addSql('ALTER TABLE notifications RENAME COLUMN created_at TO create_at');
        $this->addSql('ALTER TABLE notifications ALTER COLUMN create_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE notifications ALTER COLUMN create_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('COMMENT ON COLUMN notifications.create_at IS NULL');
        $this->addSql('ALTER TABLE notifications_users DROP is_read');
        $this->addSql('ALTER TABLE notifications_users DROP read_at');
    }
}
