<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260430075402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE eleve (id INT NOT NULL AUTO_INCREMENT, nom_eleve VARCHAR(150) NOT NULL, prenom_eleve VARCHAR(150) NOT NULL, prof_referent VARCHAR(150) DEFAULT NULL, prof_visite VARCHAR(150) DEFAULT NULL, option_eleve_id INT DEFAULT NULL, promotion_eleve_id INT DEFAULT NULL, stage_eleve_id INT DEFAULT NULL, PRIMARY KEY(id), KEY IDX_ECA105F72A1BB616 (option_eleve_id), KEY IDX_ECA105F7CC3863F6 (promotion_eleve_id), KEY IDX_ECA105F728B03DF (stage_eleve_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE `utf8mb4_0900_ai_ci`');
        $this->addSql('CREATE TABLE entreprise (id INT NOT NULL AUTO_INCREMENT, nom_entreprise VARCHAR(200) NOT NULL, adresse_entreprise VARCHAR(200) NOT NULL, cpentreprise INT NOT NULL, ville_entreprise VARCHAR(200) NOT NULL, tuteur_entreprise VARCHAR(150) NOT NULL, telephone_entreprise VARCHAR(20) NOT NULL, mail_entreprise VARCHAR(200) NOT NULL, PRIMARY KEY(id)) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE `utf8mb4_0900_ai_ci`');
        $this->addSql('CREATE TABLE `option` (id INT NOT NULL AUTO_INCREMENT, nom_option VARCHAR(50) NOT NULL, PRIMARY KEY(id)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE `utf8mb4_0900_ai_ci`');
        $this->addSql('CREATE TABLE promotion (id INT NOT NULL AUTO_INCREMENT, classe_promotion VARCHAR(100) NOT NULL, annee_promotion VARCHAR(20) NOT NULL, PRIMARY KEY(id)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE `utf8mb4_0900_ai_ci`');
        $this->addSql('CREATE TABLE `role` (id INT NOT NULL AUTO_INCREMENT, nom_role VARCHAR(50) NOT NULL, PRIMARY KEY(id)) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE `utf8mb4_0900_ai_ci`');
        $this->addSql('CREATE TABLE stage (id INT NOT NULL AUTO_INCREMENT, descriptif_stage VARCHAR(255) DEFAULT NULL, date_debut_stage DATE DEFAULT NULL, date_fin_stage DATE DEFAULT NULL, duree_stage INT DEFAULT NULL, entreprise_stage_id INT NOT NULL, PRIMARY KEY(id), KEY IDX_C27C93697048D716 (entreprise_stage_id)) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE `utf8mb4_0900_ai_ci`');
        $this->addSql('CREATE TABLE utilisateur (id INT NOT NULL AUTO_INCREMENT, nom_utilisateur VARCHAR(150) NOT NULL, prenom_utilisateur VARCHAR(100) NOT NULL, mdputilisateur VARCHAR(255) NOT NULL, email_utilisateur VARCHAR(200) NOT NULL, role_utilisateur_id INT NOT NULL, PRIMARY KEY(id), KEY IDX_1D1C63B39201D279 (role_utilisateur_id)) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE `utf8mb4_0900_ai_ci`');
        $this->addSql('CREATE TABLE utilisateur_eleve (utilisateur_id INT NOT NULL, eleve_id INT NOT NULL, PRIMARY KEY(utilisateur_id, eleve_id), KEY IDX_2A645D29FB88E14F (utilisateur_id), KEY IDX_2A645D29A6CC7B2 (eleve_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE `utf8mb4_0900_ai_ci`');
        $this->addSql("INSERT INTO entreprise (id, nom_entreprise, adresse_entreprise, cpentreprise, ville_entreprise, tuteur_entreprise, telephone_entreprise, mail_entreprise) VALUES (1, 'Longmire', '48 Rue du Désespoir', 76100, 'Rouen', 'M. Erdogan', '06 58 64 22 18', 'contact@longmire-studio.fr')");
        $this->addSql("INSERT INTO `role` (id, nom_role) VALUES (1, 'ADMIN')");
        $this->addSql("INSERT INTO stage (id, descriptif_stage, date_debut_stage, date_fin_stage, duree_stage, entreprise_stage_id) VALUES (1, 'Un stage bien.', '2026-04-08', '2026-04-25', 14, 1)");
        $this->addSql('INSERT INTO utilisateur (id, nom_utilisateur, prenom_utilisateur, mdputilisateur, email_utilisateur, role_utilisateur_id) VALUES (1, \'Rivière\', \'Charles\', \'$2y$13$T9Djcw/.pN0X4v2RY6BHZeJFVRlO3kf25HDprMLNf5bNBxz1XvCpa\', \'c.riviere7619@laposte.net\', 1)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F728B03DF FOREIGN KEY (stage_eleve_id) REFERENCES stage (id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F72A1BB616 FOREIGN KEY (option_eleve_id) REFERENCES `option` (id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F7CC3863F6 FOREIGN KEY (promotion_eleve_id) REFERENCES promotion (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C93697048D716 FOREIGN KEY (entreprise_stage_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B39201D279 FOREIGN KEY (role_utilisateur_id) REFERENCES `role` (id)');
        $this->addSql('ALTER TABLE utilisateur_eleve ADD CONSTRAINT FK_2A645D29A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_eleve ADD CONSTRAINT FK_2A645D29FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE utilisateur_eleve DROP FOREIGN KEY FK_2A645D29FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_eleve DROP FOREIGN KEY FK_2A645D29A6CC7B2');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B39201D279');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C93697048D716');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F7CC3863F6');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F72A1BB616');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F728B03DF');
        $this->addSql('DROP TABLE utilisateur_eleve');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE stage');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE eleve');
        $this->addSql('DROP TABLE `role`');
        $this->addSql('DROP TABLE `option`');
        $this->addSql('DROP TABLE promotion');
    }
}
