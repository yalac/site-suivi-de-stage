<?php

namespace App\Entity;

use App\Repository\OptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OptionRepository::class)]
#[ORM\Table(name: '`option`')]
class Option
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'nom_option', length: 50)]
    private ?string $nomOption = null;

    /**
     * @var Collection<int, Eleve>
     */
    #[ORM\OneToMany(targetEntity: Eleve::class, mappedBy: 'optionEleve')]
    private Collection $eleves;

    public function __construct()
    {
        $this->eleves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomOption(): ?string
    {
        return $this->nomOption;
    }

    public function setNomOption(string $nomOption): static
    {
        $this->nomOption = $nomOption;
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
            $eleve->setOptionEleve($this);
        }
        return $this;
    }

    public function removeEleve(Eleve $eleve): static
    {
        if ($this->eleves->removeElement($eleve)) {
            if ($eleve->getOptionEleve() === $this) {
                $eleve->setOptionEleve(null);
            }
        }
        return $this;
    }

    public function __toString(): string
    {
        return $this->nomOption ?? '';
    }
}
