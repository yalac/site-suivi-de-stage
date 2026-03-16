<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260316100433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE eleve (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, prof_referent_id INT NOT NULL, INDEX IDX_ECA105F7F9D4A789 (prof_referent_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(150) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, ville VARCHAR(100) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, date_debut DATE DEFAULT NULL, date_fin DATE DEFAULT NULL, eleve_id INT NOT NULL, entreprise_id INT NOT NULL, INDEX IDX_C27C9369A6CC7B2 (eleve_id), INDEX IDX_C27C9369A4AEAFEA (entreprise_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F7F9D4A789 FOREIGN KEY (prof_referent_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY `FK_1483A5E9F9D4A789`');
        $this->addSql('DROP INDEX IDX_1483A5E9F9D4A789 ON users');
        $this->addSql('ALTER TABLE users DROP prof_referent_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F7F9D4A789');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369A6CC7B2');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369A4AEAFEA');
        $this->addSql('DROP TABLE eleve');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE stage');
        $this->addSql('ALTER TABLE users ADD prof_referent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT `FK_1483A5E9F9D4A789` FOREIGN KEY (prof_referent_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_1483A5E9F9D4A789 ON users (prof_referent_id)');
    }
}
