<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260507070612 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE eleve_utilisateur (eleve_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_987B6984A6CC7B2 (eleve_id), INDEX IDX_987B6984FB88E14F (utilisateur_id), PRIMARY KEY (eleve_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE eleve_utilisateur ADD CONSTRAINT FK_987B6984A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eleve_utilisateur ADD CONSTRAINT FK_987B6984FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY `FK_C27C93698506587B`');
        $this->addSql('DROP INDEX IDX_C27C93698506587B ON stage');
        $this->addSql('ALTER TABLE stage DROP prof_referent, DROP prof_visite, DROP eleve_principal_stage_id, CHANGE is_archived archive BOOLEAN DEFAULT false NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eleve_utilisateur DROP FOREIGN KEY FK_987B6984A6CC7B2');
        $this->addSql('ALTER TABLE eleve_utilisateur DROP FOREIGN KEY FK_987B6984FB88E14F');
        $this->addSql('DROP TABLE eleve_utilisateur');
        $this->addSql('ALTER TABLE stage ADD prof_referent VARCHAR(150) DEFAULT NULL, ADD prof_visite VARCHAR(150) DEFAULT NULL, ADD eleve_principal_stage_id INT DEFAULT NULL, CHANGE archive is_archived BOOLEAN DEFAULT false NOT NULL');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT `FK_C27C93698506587B` FOREIGN KEY (eleve_principal_stage_id) REFERENCES eleve (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_C27C93698506587B ON stage (eleve_principal_stage_id)');
    }
}
