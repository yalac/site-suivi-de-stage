<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $prenom = null;

    #[ORM\Column(length: 100)]
    private ?string $email = null;

    #[ORM\Column(length: 100)]
    private ?string $mdp = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Roles $idRole = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'elevesPrisEnCharge')]
    private ?self $profReferent = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(mappedBy: 'profReferent', targetEntity: self::class)]
    private Collection $elevesPrisEnCharge;

    public function __construct()
    {
        $this->elevesPrisEnCharge = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;

        return $this;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): static
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getIdRole(): ?Roles
    {
        return $this->idRole;
    }

    public function setIdRole(?Roles $idRole): static
    {
        $this->idRole = $idRole;

        return $this;
    }

    public function getProfReferent(): ?self
    {
        return $this->profReferent;
    }

    public function setProfReferent(?self $profReferent): static
    {
        $this->profReferent = $profReferent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getElevesPrisEnCharge(): Collection
    {
        return $this->elevesPrisEnCharge;
    }

    public function addElevesPrisEnCharge(self $eleve): static
    {
        if (!$this->elevesPrisEnCharge->contains($eleve)) {
            $this->elevesPrisEnCharge->add($eleve);
            $eleve->setProfReferent($this);
        }

        return $this;
    }

    public function removeElevesPrisEnCharge(self $eleve): static
    {
        if ($this->elevesPrisEnCharge->removeElement($eleve)) {
            if ($eleve->getProfReferent() === $this) {
                $eleve->setProfReferent(null);
            }
        }

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email ?? '';
    }

    public function getRoles(): array
    {
        $roles = [];

        if ($this->idRole !== null && $this->idRole->getNom() !== null) {
            $roles[] = $this->idRole->getNom();
        }

        $roles[] = 'ROLE_USER';

        return array_values(array_unique($roles));
    }

    public function setRoles(array $roles): static
    {
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->mdp;
    }

    public function eraseCredentials(): void
    {
    }
}
