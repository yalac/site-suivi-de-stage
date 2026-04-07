<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Supprimer les anciennes tables users et roles
 */
final class Version20260407090000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Supprimer les anciennes tables users et roles - garder uniquement utilisateur et role';
    }

    public function up(Schema $schema): void
    {
        // Migration obsolète - les anciennes tables ne sont plus créées
    }

    public function down(Schema $schema): void
    {
        // Nothing to revert
    }
}
