<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260323093601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `option` ADD id_option INT NOT NULL, ADD nom_option VARCHAR(100) NOT NULL, DROP libelle_option');
        $this->addSql('ALTER TABLE role ADD id_role INT NOT NULL, ADD nom_role VARCHAR(50) NOT NULL, DROP libelle_role');
        $this->addSql('ALTER TABLE utilisateur ADD id_utilisateur INT NOT NULL, CHANGE mdp_utilisateur mdputilisateur VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `option` ADD libelle_option VARCHAR(255) NOT NULL, DROP id_option, DROP nom_option');
        $this->addSql('ALTER TABLE role ADD libelle_role VARCHAR(255) NOT NULL, DROP id_role, DROP nom_role');
        $this->addSql('ALTER TABLE utilisateur DROP id_utilisateur, CHANGE mdputilisateur mdp_utilisateur VARCHAR(100) NOT NULL');
    }
}
