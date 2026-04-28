<?php

namespace App\Entity;

use App\Repository\StageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(name: 'duree_stage', nullable: true)]
    private ?int $dureeStage = null;

    #[ORM\ManyToOne(targetEntity: Entreprise::class)]
    #[ORM\JoinColumn(name: 'entreprise_stage_id', nullable: false)]
    private ?Entreprise $entrepriseStage = null;

    /**
     * @var Collection<int, Activite>
     */
    #[ORM\OneToMany(targetEntity: Activite::class, mappedBy: 'stageActivite', orphanRemoval: true)]
    private Collection $activites;

    public function __construct()
    {
        $this->activites = new ArrayCollection();
    }

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

    public function getDureeStage(): ?int
    {
        return $this->dureeStage;
    }

    public function setDureeStage(?int $dureeStage): static
    {
        $this->dureeStage = $dureeStage;
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

    /**
     * @return Collection<int, Activite>
     */
    public function getActivites(): Collection
    {
        return $this->activites;
    }

    public function addActivite(Activite $activite): static
    {
        if (!$this->activites->contains($activite)) {
            $this->activites->add($activite);
            $activite->setStageActivite($this);
        }

        return $this;
    }

    public function removeActivite(Activite $activite): static
    {
        if ($this->activites->removeElement($activite)) {
            if ($activite->getStageActivite() === $this) {
                $activite->setStageActivite(null);
            }
        }

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
