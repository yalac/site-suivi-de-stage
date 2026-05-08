<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\Table(name: 'utilisateur')]
#[UniqueEntity(fields: ['emailUtilisateur'], message: 'There is already an account with this email')]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'nom_utilisateur', length: 150)]
    private ?string $nomUtilisateur = null;

    #[ORM\Column(name: 'prenom_utilisateur', length: 100)]
    private ?string $prenomUtilisateur = null;

    #[ORM\Column(name: 'mdp_utilisateur', length: 255)]
    private ?string $mdpUtilisateur = null;

    #[ORM\Column(name: 'email_utilisateur', length: 200)]
    private ?string $emailUtilisateur = null;

    #[ORM\ManyToOne(inversedBy: 'utilisateurs')]
    #[ORM\JoinColumn(name: 'role_utilisateur_id', nullable: false)]
    private ?Role $roleUtilisateur = null;

    /**
     * @var Collection<int, Eleve>
     */
    #[ORM\ManyToMany(targetEntity: Eleve::class, mappedBy: 'utilisateurs')]
    private Collection $eleves;

    public function __construct()
    {
        $this->eleves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomUtilisateur(): ?string
    {
        return $this->nomUtilisateur;
    }

    public function setNomUtilisateur(string $nomUtilisateur): static
    {
        $this->nomUtilisateur = $nomUtilisateur;
        return $this;
    }

    public function getPrenomUtilisateur(): ?string
    {
        return $this->prenomUtilisateur;
    }

    public function setPrenomUtilisateur(string $prenomUtilisateur): static
    {
        $this->prenomUtilisateur = $prenomUtilisateur;
        return $this;
    }

    public function getMdpUtilisateur(): ?string
    {
        return $this->mdpUtilisateur;
    }

    public function setMdpUtilisateur(string $mdpUtilisateur): static
    {
        $this->mdpUtilisateur = $mdpUtilisateur;
        return $this;
    }

    public function getEmailUtilisateur(): ?string
    {
        return $this->emailUtilisateur;
    }

    public function setEmailUtilisateur(string $emailUtilisateur): static
    {
        $this->emailUtilisateur = $emailUtilisateur;
        return $this;
    }

    public function getRoleUtilisateur(): ?Role
    {
        return $this->roleUtilisateur;
    }

    public function setRoleUtilisateur(?Role $roleUtilisateur): static
    {
        $this->roleUtilisateur = $roleUtilisateur;
        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->emailUtilisateur;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = [];
        if ($this->roleUtilisateur) {
            $roles[] = 'ROLE_' . strtoupper($this->roleUtilisateur->getNomRole());
        }

        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->mdpUtilisateur ?? '';
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $eleve->addUtilisateur($this);
        }

        return $this;
    }

    public function removeEleve(Eleve $eleve): static
    {
        if ($this->eleves->removeElement($eleve)) {
            $eleve->removeUtilisateur($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->prenomUtilisateur . ' ' . $this->nomUtilisateur;
    }
}
