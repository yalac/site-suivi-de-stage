<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260512065320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE eleve (id INT AUTO_INCREMENT NOT NULL, nom_eleve VARCHAR(150) NOT NULL, prenom_eleve VARCHAR(150) NOT NULL, option_eleve_id INT DEFAULT NULL, promotion_eleve_id INT DEFAULT NULL, stage_eleve_id INT DEFAULT NULL, INDEX IDX_ECA105F72A1BB616 (option_eleve_id), INDEX IDX_ECA105F7CC3863F6 (promotion_eleve_id), UNIQUE INDEX UNIQ_ECA105F728B03DF (stage_eleve_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE eleve_utilisateur (eleve_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_987B6984A6CC7B2 (eleve_id), INDEX IDX_987B6984FB88E14F (utilisateur_id), PRIMARY KEY (eleve_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, nom_entreprise VARCHAR(200) NOT NULL, adresse_entreprise VARCHAR(200) NOT NULL, cpentreprise INT NOT NULL, ville_entreprise VARCHAR(200) NOT NULL, tuteur_entreprise VARCHAR(150) NOT NULL, telephone_entreprise VARCHAR(20) NOT NULL, mail_entreprise VARCHAR(200) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE historique (id INT AUTO_INCREMENT NOT NULL, date_modification DATETIME NOT NULL, type_action VARCHAR(50) NOT NULL, champ_modifie VARCHAR(100) DEFAULT NULL, ancienne_valeur LONGTEXT DEFAULT NULL, nouvelle_valeur LONGTEXT DEFAULT NULL, type_entite VARCHAR(50) NOT NULL, eleve_id INT DEFAULT NULL, entreprise_id INT DEFAULT NULL, stage_id INT DEFAULT NULL, utilisateur_id INT DEFAULT NULL, INDEX IDX_EDBFD5ECA6CC7B2 (eleve_id), INDEX IDX_EDBFD5ECA4AEAFEA (entreprise_id), INDEX IDX_EDBFD5EC2298D193 (stage_id), INDEX IDX_EDBFD5ECFB88E14F (utilisateur_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, nom_option VARCHAR(50) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE promotion (id INT AUTO_INCREMENT NOT NULL, classe_promotion VARCHAR(100) NOT NULL, annee_promotion VARCHAR(20) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, nom_role VARCHAR(50) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, descriptif_stage VARCHAR(255) DEFAULT NULL, date_debut_stage DATE DEFAULT NULL, date_fin_stage DATE DEFAULT NULL, prof_referent VARCHAR(150) DEFAULT NULL, prof_visite VARCHAR(150) DEFAULT NULL, commentaire LONGTEXT DEFAULT NULL, entreprise_stage_id INT NOT NULL, INDEX IDX_C27C93697048D716 (entreprise_stage_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom_utilisateur VARCHAR(150) NOT NULL, prenom_utilisateur VARCHAR(100) NOT NULL, mdp_utilisateur VARCHAR(255) NOT NULL, email_utilisateur VARCHAR(200) NOT NULL, role_utilisateur_id INT NOT NULL, INDEX IDX_1D1C63B39201D279 (role_utilisateur_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F72A1BB616 FOREIGN KEY (option_eleve_id) REFERENCES `option` (id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F7CC3863F6 FOREIGN KEY (promotion_eleve_id) REFERENCES promotion (id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F728B03DF FOREIGN KEY (stage_eleve_id) REFERENCES stage (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE eleve_utilisateur ADD CONSTRAINT FK_987B6984A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eleve_utilisateur ADD CONSTRAINT FK_987B6984FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5ECA6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5ECA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5EC2298D193 FOREIGN KEY (stage_id) REFERENCES stage (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5ECFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C93697048D716 FOREIGN KEY (entreprise_stage_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B39201D279 FOREIGN KEY (role_utilisateur_id) REFERENCES role (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F72A1BB616');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F7CC3863F6');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F728B03DF');
        $this->addSql('ALTER TABLE eleve_utilisateur DROP FOREIGN KEY FK_987B6984A6CC7B2');
        $this->addSql('ALTER TABLE eleve_utilisateur DROP FOREIGN KEY FK_987B6984FB88E14F');
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5ECA6CC7B2');
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5ECA4AEAFEA');
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5EC2298D193');
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5ECFB88E14F');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C93697048D716');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B39201D279');
        $this->addSql('DROP TABLE eleve');
        $this->addSql('DROP TABLE eleve_utilisateur');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE historique');
        $this->addSql('DROP TABLE `option`');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE stage');
        $this->addSql('DROP TABLE utilisateur');
    }
}
