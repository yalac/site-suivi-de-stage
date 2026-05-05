<?php

namespace App\Entity;

use App\Repository\EleveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EleveRepository::class)]
class Eleve
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'nom_eleve', length: 150)]
    private ?string $nomEleve = null;

    #[ORM\Column(name: 'prenom_eleve', length: 150)]
    private ?string $prenomEleve = null;

    #[ORM\Column(name: 'prof_referent', length: 150, nullable: true)]
    private ?string $profReferent = null;

    #[ORM\Column(name: 'prof_visite', length: 150, nullable: true)]
    private ?string $profVisite = null;

    #[ORM\ManyToOne(targetEntity: Option::class)]
    #[ORM\JoinColumn(name: 'option_eleve_id', nullable: true)]
    private ?Option $optionEleve = null;

    #[ORM\ManyToOne(targetEntity: Promotion::class, inversedBy: 'eleves')]
    #[ORM\JoinColumn(name: 'promotion_eleve_id', nullable: true)]
    private ?Promotion $promotionEleve = null;

    #[ORM\ManyToOne(targetEntity: Stage::class)]
    #[ORM\JoinColumn(name: 'stage_eleve_id', nullable: true)]
    private ?Stage $stageEleve = null;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEleve(): ?string
    {
        return $this->nomEleve;
    }

    public function setNomEleve(string $nomEleve): static
    {
        $this->nomEleve = $nomEleve;
        return $this;
    }

    public function getPrenomEleve(): ?string
    {
        return $this->prenomEleve;
    }

    public function setPrenomEleve(string $prenomEleve): static
    {
        $this->prenomEleve = $prenomEleve;
        return $this;
    }

    public function getProfReferent(): ?string
    {
        return $this->profReferent;
    }

    public function setProfReferent(?string $profReferent): static
    {
        $this->profReferent = $profReferent;
        return $this;
    }

    public function getProfVisite(): ?string
    {
        return $this->profVisite;
    }

    public function setProfVisite(?string $profVisite): static
    {
        $this->profVisite = $profVisite;
        return $this;
    }

    public function getOptionEleve(): ?Option
    {
        return $this->optionEleve;
    }

    public function setOptionEleve(?Option $optionEleve): static
    {
        $this->optionEleve = $optionEleve;
        return $this;
    }

    public function getPromotionEleve(): ?Promotion
    {
        return $this->promotionEleve;
    }

    public function setPromotionEleve(?Promotion $promotionEleve): static
    {
        $this->promotionEleve = $promotionEleve;
        return $this;
    }

    public function getStageEleve(): ?Stage
    {
        return $this->stageEleve;
    }

    public function setStageEleve(?Stage $stageEleve): static
    {
        $this->stageEleve = $stageEleve;
        return $this;
    }
}
