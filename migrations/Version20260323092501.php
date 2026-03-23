<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260323092501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE eleve (id INT AUTO_INCREMENT NOT NULL, id_eleve INT NOT NULL, nom_eleve VARCHAR(100) NOT NULL, prenom_eleve VARCHAR(100) NOT NULL, classe_eleve VARCHAR(36) NOT NULL, annee_eleve INT NOT NULL, prof_referent VARCHAR(100) NOT NULL, prof_visite VARCHAR(100) NOT NULL, fk_option_id INT NOT NULL, fk_stage_id INT NOT NULL, INDEX IDX_ECA105F7C69DCAFF (fk_option_id), INDEX IDX_ECA105F710B0924D (fk_stage_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, id_entreprise INT NOT NULL, nom_entreprise VARCHAR(100) NOT NULL, adresse_entreprise VARCHAR(255) NOT NULL, cpentreprise INT NOT NULL, ville_entreprise VARCHAR(150) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, id_option INT NOT NULL, nom_option VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, id_role INT NOT NULL, nom_role VARCHAR(50) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, id_stage INT NOT NULL, descriptif_stage LONGTEXT NOT NULL, date_debut_stage INT NOT NULL, data_fin_stage INT NOT NULL, duree_stage INT NOT NULL, fk_entreprise_id INT NOT NULL, INDEX IDX_C27C9369C0E4DA28 (fk_entreprise_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, id_utilisateur INT NOT NULL, nom_utilisateur VARCHAR(100) NOT NULL, prenom_utilisateur VARCHAR(100) NOT NULL, mdputilisateur VARCHAR(100) NOT NULL, email_utilisateur VARCHAR(150) NOT NULL, fk_role_id INT NOT NULL, INDEX IDX_1D1C63B3262C1F80 (fk_role_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F7C69DCAFF FOREIGN KEY (fk_option_id) REFERENCES `option` (id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F710B0924D FOREIGN KEY (fk_stage_id) REFERENCES stage (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369C0E4DA28 FOREIGN KEY (fk_entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3262C1F80 FOREIGN KEY (fk_role_id) REFERENCES role (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F7C69DCAFF');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F710B0924D');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369C0E4DA28');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3262C1F80');
        $this->addSql('DROP TABLE eleve');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE `option`');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE stage');
        $this->addSql('DROP TABLE utilisateur');
    }
}
