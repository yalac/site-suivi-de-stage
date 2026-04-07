<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260407085858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activite (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, id_stage INT NOT NULL, INDEX IDX_B87555152CF9D259 (id_stage), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE eleve (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, id_utilisateur_referent INT NOT NULL, promotion_id INT DEFAULT NULL, INDEX IDX_ECA105F7EC11A457 (id_utilisateur_referent), INDEX IDX_ECA105F7139DF194 (promotion_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(150) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, ville VARCHAR(100) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE promotion (id INT AUTO_INCREMENT NOT NULL, classe VARCHAR(255) NOT NULL, session VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, date_debut DATE DEFAULT NULL, date_fin DATE DEFAULT NULL, id_eleve INT NOT NULL, id_entreprise INT NOT NULL, service_id INT DEFAULT NULL, INDEX IDX_C27C936922444C7 (id_eleve), INDEX IDX_C27C9369A8937AB7 (id_entreprise), INDEX IDX_C27C9369ED5CA9E6 (service_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, mot_de_passe VARCHAR(100) NOT NULL, id_role INT NOT NULL, INDEX IDX_1D1C63B3DC499668 (id_role), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B87555152CF9D259 FOREIGN KEY (id_stage) REFERENCES stage (id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F7EC11A457 FOREIGN KEY (id_utilisateur_referent) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F7139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C936922444C7 FOREIGN KEY (id_eleve) REFERENCES eleve (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369A8937AB7 FOREIGN KEY (id_entreprise) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3DC499668 FOREIGN KEY (id_role) REFERENCES role (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B87555152CF9D259');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F7EC11A457');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F7139DF194');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C936922444C7');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369A8937AB7');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369ED5CA9E6');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3DC499668');
        $this->addSql('DROP TABLE activite');
        $this->addSql('DROP TABLE eleve');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE stage');
        $this->addSql('DROP TABLE utilisateur');
    }
}
