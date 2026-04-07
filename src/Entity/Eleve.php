<?php

namespace App\Entity;

use App\Repository\EleveRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EleveRepository::class)]
class Eleve
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $prenom = null;

    #[ORM\ManyToOne(targetEntity: Users::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $profReferent = null;

    #[ORM\ManyToOne(targetEntity: Promotion::class, inversedBy: 'eleves')]
    private ?Promotion $promotion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getProfReferent(): ?Users
    {
        return $this->profReferent;
    }

    public function setProfReferent(?Users $profReferent): static
    {
        $this->profReferent = $profReferent;

        return $this;
    }

    public function getPromotion(): ?Promotion
    {
        return $this->promotion;
    }

    public function setPromotion(?Promotion $promotion): static
    {
        $this->promotion = $promotion;

        return $this;
    }
    /* Calcul TRIGRAMME */
    public function getTrigramme(): string
    {
        $prenom = strtoupper(substr($this->prenom ?? '', 0, 1));
        $nom = strtoupper(substr($this->nom ?? '', 0, 2));

        return $prenom . $nom;
    }
}
