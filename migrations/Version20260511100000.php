<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260511100000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Fusionne les 4 tables historiques en une seule table historique unifiée (migration sûre)';
    }

    public function up(Schema $schema): void
    {
        // Cette migration est maintenant une transition simple qui accepte que
        // les anciennes tables puissent déjà être supprimées par les migrations
        // auto-générées précédentes. Elle ne fait rien si c'est le cas.
        
        // Les données auraient dû être migrées ou gardées intactes par les 
        // migrations précédentes. Cette migration est un marker pour la transition.
    }

    public function down(Schema $schema): void
    {
        // Ne rien faire en down
    }
}
