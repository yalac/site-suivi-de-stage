<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260323094608 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, mdp VARCHAR(100) NOT NULL, id_role_id INT NOT NULL, INDEX IDX_1483A5E989E8BDC (id_role_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E989E8BDC FOREIGN KEY (id_role_id) REFERENCES roles (id)');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY `FK_1D1C63B3262C1F80`');
        $this->addSql('DROP TABLE `option`');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY `FK_ECA105F710B0924D`');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY `FK_ECA105F7C69DCAFF`');
        $this->addSql('DROP INDEX IDX_ECA105F710B0924D ON eleve');
        $this->addSql('DROP INDEX IDX_ECA105F7C69DCAFF ON eleve');
        $this->addSql('ALTER TABLE eleve ADD nom VARCHAR(50) NOT NULL, ADD prenom VARCHAR(50) NOT NULL, ADD prof_referent_id INT NOT NULL, DROP id_eleve, DROP nom_eleve, DROP prenom_eleve, DROP classe_eleve, DROP annee_eleve, DROP prof_referent, DROP prof_visite, DROP fk_option_id, DROP fk_stage_id');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F7F9D4A789 FOREIGN KEY (prof_referent_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_ECA105F7F9D4A789 ON eleve (prof_referent_id)');
        $this->addSql('ALTER TABLE entreprise ADD adresse VARCHAR(255) DEFAULT NULL, ADD ville VARCHAR(100) DEFAULT NULL, DROP id_entreprise, DROP nom_entreprise, DROP adresse_entreprise, DROP cpentreprise, CHANGE ville_entreprise nom VARCHAR(150) NOT NULL');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY `FK_C27C9369C0E4DA28`');
        $this->addSql('DROP INDEX IDX_C27C9369C0E4DA28 ON stage');
        $this->addSql('ALTER TABLE stage ADD date_debut DATE DEFAULT NULL, ADD date_fin DATE DEFAULT NULL, ADD eleve_id INT NOT NULL, ADD entreprise_id INT NOT NULL, DROP id_stage, DROP descriptif_stage, DROP date_debut_stage, DROP data_fin_stage, DROP duree_stage, DROP fk_entreprise_id');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('CREATE INDEX IDX_C27C9369A6CC7B2 ON stage (eleve_id)');
        $this->addSql('CREATE INDEX IDX_C27C9369A4AEAFEA ON stage (entreprise_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, libelle_option VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, libelle_role VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom_utilisateur VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, prenom_utilisateur VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, mdp_utilisateur VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, email_utilisateur VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, fk_role_id INT NOT NULL, INDEX IDX_1D1C63B3262C1F80 (fk_role_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT `FK_1D1C63B3262C1F80` FOREIGN KEY (fk_role_id) REFERENCES role (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E989E8BDC');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE users');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F7F9D4A789');
        $this->addSql('DROP INDEX IDX_ECA105F7F9D4A789 ON eleve');
        $this->addSql('ALTER TABLE eleve ADD nom_eleve VARCHAR(100) NOT NULL, ADD prenom_eleve VARCHAR(100) NOT NULL, ADD classe_eleve VARCHAR(36) NOT NULL, ADD annee_eleve INT NOT NULL, ADD prof_referent VARCHAR(100) NOT NULL, ADD prof_visite VARCHAR(100) NOT NULL, ADD fk_option_id INT NOT NULL, ADD fk_stage_id INT NOT NULL, DROP nom, DROP prenom, CHANGE prof_referent_id id_eleve INT NOT NULL');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT `FK_ECA105F710B0924D` FOREIGN KEY (fk_stage_id) REFERENCES stage (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT `FK_ECA105F7C69DCAFF` FOREIGN KEY (fk_option_id) REFERENCES `option` (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_ECA105F710B0924D ON eleve (fk_stage_id)');
        $this->addSql('CREATE INDEX IDX_ECA105F7C69DCAFF ON eleve (fk_option_id)');
        $this->addSql('ALTER TABLE entreprise ADD id_entreprise INT NOT NULL, ADD nom_entreprise VARCHAR(100) NOT NULL, ADD adresse_entreprise VARCHAR(255) NOT NULL, ADD cpentreprise INT NOT NULL, DROP adresse, DROP ville, CHANGE nom ville_entreprise VARCHAR(150) NOT NULL');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369A6CC7B2');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369A4AEAFEA');
        $this->addSql('DROP INDEX IDX_C27C9369A6CC7B2 ON stage');
        $this->addSql('DROP INDEX IDX_C27C9369A4AEAFEA ON stage');
        $this->addSql('ALTER TABLE stage ADD id_stage INT NOT NULL, ADD descriptif_stage LONGTEXT NOT NULL, ADD date_debut_stage INT NOT NULL, ADD data_fin_stage INT NOT NULL, ADD duree_stage INT NOT NULL, ADD fk_entreprise_id INT NOT NULL, DROP date_debut, DROP date_fin, DROP eleve_id, DROP entreprise_id');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT `FK_C27C9369C0E4DA28` FOREIGN KEY (fk_entreprise_id) REFERENCES entreprise (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_C27C9369C0E4DA28 ON stage (fk_entreprise_id)');
    }
}
