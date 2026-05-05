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
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activite (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, stage_activite_id INT NOT NULL, INDEX IDX_B87555154AF8B55B (stage_activite_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B87555154AF8B55B FOREIGN KEY (stage_activite_id) REFERENCES stage (id)');
        $this->addSql('ALTER TABLE eleve CHANGE prof_referent prof_referent VARCHAR(150) DEFAULT NULL, CHANGE prof_visite prof_visite VARCHAR(150) DEFAULT NULL, CHANGE option_eleve_id option_eleve_id INT DEFAULT NULL, CHANGE promotion_eleve_id promotion_eleve_id INT DEFAULT NULL, CHANGE stage_eleve_id stage_eleve_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stage CHANGE descriptif_stage descriptif_stage VARCHAR(255) DEFAULT NULL, CHANGE date_debut_stage date_debut_stage DATE DEFAULT NULL, CHANGE date_fin_stage date_fin_stage DATE DEFAULT NULL, CHANGE duree_stage duree_stage INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur CHANGE mdputilisateur mdp_utilisateur VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B87555154AF8B55B');
        $this->addSql('DROP TABLE activite');
        $this->addSql('DROP TABLE service');
        $this->addSql('ALTER TABLE eleve CHANGE prof_referent prof_referent VARCHAR(150) NOT NULL, CHANGE prof_visite prof_visite VARCHAR(150) NOT NULL, CHANGE option_eleve_id option_eleve_id INT NOT NULL, CHANGE promotion_eleve_id promotion_eleve_id INT NOT NULL, CHANGE stage_eleve_id stage_eleve_id INT NOT NULL');
        $this->addSql('ALTER TABLE stage CHANGE descriptif_stage descriptif_stage VARCHAR(255) NOT NULL, CHANGE date_debut_stage date_debut_stage DATE NOT NULL, CHANGE date_fin_stage date_fin_stage DATE NOT NULL, CHANGE duree_stage duree_stage INT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur CHANGE mdp_utilisateur mdputilisateur VARCHAR(255) NOT NULL');
    }
}
