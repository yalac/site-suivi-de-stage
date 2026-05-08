<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260508092000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Remove obsolete eleve.stage_eleve_id relation in favor of stage.eleve_stage_id.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F728B03DF');
        $this->addSql('DROP INDEX IDX_ECA105F728B03DF ON eleve');
        $this->addSql('ALTER TABLE eleve DROP stage_eleve_id');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE eleve ADD stage_eleve_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_ECA105F728B03DF ON eleve (stage_eleve_id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F728B03DF FOREIGN KEY (stage_eleve_id) REFERENCES stage (id) ON DELETE SET NULL');
    }
}