<?php

namespace App\Entity;

use App\Repository\StageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StageRepository::class)]
class Stage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descriptifStage = null;

    #[ORM\Column(name: 'date_debut_stage', type: 'date', nullable: true)]
    private ?\DateTimeInterface $dateDebutStage = null;

    #[ORM\Column(name: 'date_fin_stage', type: 'date', nullable: true)]
    private ?\DateTimeInterface $dateFinStage = null;

    #[ORM\ManyToOne(targetEntity: Entreprise::class)]
    #[ORM\JoinColumn(name: 'entreprise_stage_id', nullable: false)]
    private ?Entreprise $entrepriseStage = null;

    #[ORM\OneToOne(mappedBy: 'stageEleve', targetEntity: Eleve::class)]
    private ?Eleve $eleveStage = null;

    #[ORM\Column(name: 'prof_referent', length: 150, nullable: true)]
    private ?string $profReferent = null;

    #[ORM\Column(name: 'prof_visite', length: 150, nullable: true)]
    private ?string $profVisite = null;

    #[ORM\Column(name: 'commentaire', type: 'text', nullable: true)]
    private ?string $commentaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescriptifStage(): ?string
    {
        return $this->descriptifStage;
    }

    public function setDescriptifStage(?string $descriptifStage): static
    {
        $this->descriptifStage = $descriptifStage;
        return $this;
    }

    public function getDateDebutStage(): ?\DateTimeInterface
    {
        return $this->dateDebutStage;
    }

    public function setDateDebutStage(?\DateTimeInterface $dateDebutStage): static
    {
        $this->dateDebutStage = $dateDebutStage;
        return $this;
    }

    public function getDateFinStage(): ?\DateTimeInterface
    {
        return $this->dateFinStage;
    }

    public function setDateFinStage(?\DateTimeInterface $dateFinStage): static
    {
        $this->dateFinStage = $dateFinStage;
        return $this;
    }

    public function getEntrepriseStage(): ?Entreprise
    {
        return $this->entrepriseStage;
    }

    public function setEntrepriseStage(?Entreprise $entrepriseStage): static
    {
        $this->entrepriseStage = $entrepriseStage;
        return $this;
    }

    public function getEleveStage(): ?Eleve
    {
        return $this->eleveStage;
    }

    public function setEleveStage(?Eleve $eleveStage): static
    {
        if ($eleveStage === null && $this->eleveStage !== null) {
            $this->eleveStage->setStageEleve(null);
        }

        if ($eleveStage !== null && $eleveStage->getStageEleve() !== $this) {
            $eleveStage->setStageEleve($this);
        }

        $this->eleveStage = $eleveStage;

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

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): static
    {
        $this->commentaire = $commentaire;
        return $this;
    }

    public function __toString(): string
    {
        $entreprise = $this->entrepriseStage?->getNomEntreprise() ?? 'N/A';
        $debut = $this->dateDebutStage?->format('Y-m-d') ?? '?';
        $fin = $this->dateFinStage?->format('Y-m-d') ?? '?';
        return "$entreprise ($debut - $fin)";
    }
}
