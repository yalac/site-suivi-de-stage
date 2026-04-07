<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Restructuration complète en MERISE - nouvelle DB
 */
final class Version20260407100000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Restructuration complète de la base de données selon MERISE';
    }

    public function up(Schema $schema): void
    {
        // Disable FK checks to allow DROP of referenced tables
        $this->addSql('SET FOREIGN_KEY_CHECKS=0');

        // Drop existing tables
        $this->addSql('DROP TABLE IF EXISTS utilisateur_eleve');
        $this->addSql('DROP TABLE IF EXISTS activite');
        $this->addSql('DROP TABLE IF EXISTS stage');
        $this->addSql('DROP TABLE IF EXISTS eleve');
        $this->addSql('DROP TABLE IF EXISTS entreprise');
        $this->addSql('DROP TABLE IF EXISTS promotion');
        $this->addSql('DROP TABLE IF EXISTS service');
        $this->addSql('DROP TABLE IF EXISTS utilisateur');
        $this->addSql('DROP TABLE IF EXISTS role');
        $this->addSql('DROP TABLE IF EXISTS `option`');

        // Re-enable FK checks
        $this->addSql('SET FOREIGN_KEY_CHECKS=1');

        // Create option table (option is a reserved keyword, must be escaped)
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, nom_option VARCHAR(50) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');

        // Create role table
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, nom_role VARCHAR(50) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');

        // Create utilisateur table
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom_utilisateur VARCHAR(150) NOT NULL, prenom_utilisateur VARCHAR(100) NOT NULL, mdputilisateur VARCHAR(255) NOT NULL, email_utilisateur VARCHAR(200) NOT NULL, role_utilisateur_id INT NOT NULL, INDEX IDX_1D1C63B39201D279 (role_utilisateur_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');

        // Create promotion table
        $this->addSql('CREATE TABLE promotion (id INT AUTO_INCREMENT NOT NULL, classe_promotion VARCHAR(100) NOT NULL, annee_promotion VARCHAR(20) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');

        // Create entreprise table
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, nom_entreprise VARCHAR(200) NOT NULL, adresse_entreprise VARCHAR(200) NOT NULL, cpentreprise INT NOT NULL, ville_entreprise VARCHAR(200) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');

        // Create stage table
        $this->addSql('CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, descriptif_stage VARCHAR(255), date_debut_stage DATE, date_fin_stage DATE, duree_stage INT, entreprise_stage_id INT NOT NULL, INDEX IDX_C27C93697048D716 (entreprise_stage_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');

        // Create eleve table
        $this->addSql('CREATE TABLE eleve (id INT AUTO_INCREMENT NOT NULL, nom_eleve VARCHAR(150) NOT NULL, prenom_eleve VARCHAR(150) NOT NULL, prof_referent VARCHAR(150) NOT NULL, prof_visite VARCHAR(150) NOT NULL, option_eleve_id INT DEFAULT NULL, promotion_eleve_id INT DEFAULT NULL, stage_eleve_id INT DEFAULT NULL, INDEX IDX_ECA105F72A1BB616 (option_eleve_id), INDEX IDX_ECA105F7CC3863F6 (promotion_eleve_id), INDEX IDX_ECA105F728B03DF (stage_eleve_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');

        // Create utilisateur_eleve table (liaison)
        $this->addSql('CREATE TABLE utilisateur_eleve (utilisateur_id INT NOT NULL, eleve_id INT NOT NULL, PRIMARY KEY (utilisateur_id, eleve_id), INDEX IDX_2A645D29FB88E14F (utilisateur_id), INDEX IDX_2A645D29A6CC7B2 (eleve_id)) DEFAULT CHARACTER SET utf8mb4');

        // Create activite table
        $this->addSql('CREATE TABLE activite (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, stage_activite_id INT NOT NULL, INDEX IDX_B87555155E6CE1FB (stage_activite_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');

        // Add constraints
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B39201D279 FOREIGN KEY (role_utilisateur_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C93697048D716 FOREIGN KEY (entreprise_stage_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F72A1BB616 FOREIGN KEY (option_eleve_id) REFERENCES `option` (id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F7CC3863F6 FOREIGN KEY (promotion_eleve_id) REFERENCES promotion (id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F728B03DF FOREIGN KEY (stage_eleve_id) REFERENCES stage (id)');
        $this->addSql('ALTER TABLE utilisateur_eleve ADD CONSTRAINT FK_2A645D29FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_eleve ADD CONSTRAINT FK_2A645D29A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B87555155E6CE1FB FOREIGN KEY (stage_activite_id) REFERENCES stage (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE utilisateur_eleve DROP FOREIGN KEY FK_2A645D29A6CC7B2');
        $this->addSql('ALTER TABLE utilisateur_eleve DROP FOREIGN KEY FK_2A645D29FB88E14F');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B87555155E6CE1FB');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F728B03DF');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F7CC3863F6');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F72A1BB616');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C93697048D716');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B39201D279');
        $this->addSql('DROP TABLE activite');
        $this->addSql('DROP TABLE utilisateur_eleve');
        $this->addSql('DROP TABLE eleve');
        $this->addSql('DROP TABLE stage');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE option');
    }
}
