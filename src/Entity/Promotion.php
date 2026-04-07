<?php

namespace App\Entity;

use App\Repository\PromotionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromotionRepository::class)]
class Promotion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'classe_promotion', length: 100)]
    private ?string $classePromotion = null;

    #[ORM\Column(name: 'annee_promotion', length: 20)]
    private ?string $anneePromotion = null;

    /**
     * @var Collection<int, Eleve>
     */
    #[ORM\OneToMany(targetEntity: Eleve::class, mappedBy: 'promotionEleve')]
    private Collection $eleves;

    public function __construct()
    {
        $this->eleves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClassePromotion(): ?string
    {
        return $this->classePromotion;
    }

    public function setClassePromotion(string $classePromotion): static
    {
        $this->classePromotion = $classePromotion;
        return $this;
    }

    public function getAnneePromotion(): ?string
    {
        return $this->anneePromotion;
    }

    public function setAnneePromotion(string $anneePromotion): static
    {
        $this->anneePromotion = $anneePromotion;
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
            $eleve->setPromotionEleve($this);
        }

        return $this;
    }

    public function removeEleve(Eleve $eleve): static
    {
        if ($this->eleves->removeElement($eleve)) {
            // set the owning side to null (unless already changed)
            if ($eleve->getPromotionEleve() === $this) {
                $eleve->setPromotionEleve(null);
            }
        }

        return $this;
    }
}
