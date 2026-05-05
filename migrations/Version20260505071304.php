<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260505071304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stage ADD eleve_principal_stage_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C93698506587B FOREIGN KEY (eleve_principal_stage_id) REFERENCES eleve (id)');
        $this->addSql('CREATE INDEX IDX_C27C93698506587B ON stage (eleve_principal_stage_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C93698506587B');
        $this->addSql('DROP INDEX IDX_C27C93698506587B ON stage');
        $this->addSql('ALTER TABLE stage DROP eleve_principal_stage_id');
    }
}
