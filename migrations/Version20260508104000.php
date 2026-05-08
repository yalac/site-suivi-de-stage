<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260508104000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Remove duree_stage column from stage table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE stage DROP duree_stage');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE stage ADD duree_stage INT DEFAULT NULL');
    }
}
