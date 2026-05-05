<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Rename mdputilisateur column to mdp_utilisateur to match Doctrine mapping
 */
final class Version20260505080000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rename mdputilisateur column to mdp_utilisateur to match Doctrine entity mapping';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE utilisateur CHANGE mdputilisateur mdp_utilisateur VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE utilisateur CHANGE mdp_utilisateur mdputilisateur VARCHAR(255) NOT NULL');
    }
}
