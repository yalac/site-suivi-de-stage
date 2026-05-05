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

    #[ORM\ManyToOne(targetEntity: Eleve::class)]
    #[ORM\JoinColumn(name: 'eleve_principal_stage_id', nullable: true)]
    private ?Eleve $elevePrincipalStage = null;

    /**
     * @var Collection<int, Eleve>
     */
    #[ORM\OneToMany(targetEntity: Eleve::class, mappedBy: 'stageEleve')]
    private Collection $eleves;

    public function __construct()
    {
        $this->eleves = new ArrayCollection();
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

    public function getElevePrincipalStage(): ?Eleve
    {
        return $this->elevePrincipalStage;
    }

    public function setElevePrincipalStage(?Eleve $elevePrincipalStage): static
    {
        $this->elevePrincipalStage = $elevePrincipalStage;
        return $this;
    }

    /**
     * @return Collection<int, Eleve>
     */
    public function getEleves(): Collection
    {
        return $this->eleves;
    }

    public function addEleve(Eleve $eleve): static
    {
        if (!$this->eleves->contains($eleve)) {
            $this->eleves->add($eleve);
            $eleve->setStageEleve($this);
        }

        return $this;
    }

    public function removeEleve(Eleve $eleve): static
    {
        if ($this->eleves->removeElement($eleve)) {
            if ($eleve->getStageEleve() === $this) {
                $eleve->setStageEleve(null);
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
