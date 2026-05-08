<?php

namespace App\Entity;

use App\Repository\HistoriqueUtilisateurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoriqueUtilisateurRepository::class)]
#[ORM\Table(name: 'historique_utilisateur')]
class HistoriqueUtilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'utilisateur_id', nullable: true, onDelete: 'SET NULL')]
    private ?Utilisateur $utilisateur = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $dateModification = null;

    #[ORM\Column(length: 50)]
    private ?string $typeAction = null; // 'créé', 'modifié', 'supprimé'

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $champModifie = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ancienneValeur = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $nouvelleValeur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }

    public function getDateModification(): ?\DateTimeImmutable
    {
        return $this->dateModification;
    }

    public function setDateModification(\DateTimeImmutable $dateModification): static
    {
        $this->dateModification = $dateModification;
        return $this;
    }

    public function getTypeAction(): ?string
    {
        return $this->typeAction;
    }

    public function setTypeAction(string $typeAction): static
    {
        $this->typeAction = $typeAction;
        return $this;
    }

    public function getChampModifie(): ?string
    {
        return $this->champModifie;
    }

    public function setChampModifie(?string $champModifie): static
    {
        $this->champModifie = $champModifie;
        return $this;
    }

    public function getAncienneValeur(): ?string
    {
        return $this->ancienneValeur;
    }

    public function setAncienneValeur(?string $ancienneValeur): static
    {
        $this->ancienneValeur = $ancienneValeur;
        return $this;
    }

    public function getNouvelleValeur(): ?string
    {
        return $this->nouvelleValeur;
    }

    public function setNouvelleValeur(?string $nouvelleValeur): static
    {
        $this->nouvelleValeur = $nouvelleValeur;
        return $this;
    }
}
