<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntrepriseRepository::class)]
class Entreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'nom_entreprise', length: 200)]
    private ?string $nomEntreprise = null;

    #[ORM\Column(name: 'adresse_entreprise', length: 200)]
    private ?string $adresseEntreprise = null;

    #[ORM\Column(name: 'cpentreprise')]
    private ?int $cpentreprise = null;

    #[ORM\Column(name: 'ville_entreprise', length: 200)]
    private ?string $villeEntreprise = null;

    #[ORM\Column(name: 'tuteur_entreprise', length: 150)]
    private ?string $tuteurEntreprise = null;

    #[ORM\Column(name: 'telephone_entreprise', length: 20)]
    private ?string $telephoneEntreprise = null;

    #[ORM\Column(name: 'mail_entreprise', length: 200)]
    private ?string $mailEntreprise = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nomEntreprise;
    }

    public function setNomEntreprise(string $nomEntreprise): static
    {
        $this->nomEntreprise = $nomEntreprise;
        return $this;
    }

    public function getAdresseEntreprise(): ?string
    {
        return $this->adresseEntreprise;
    }

    public function setAdresseEntreprise(string $adresseEntreprise): static
    {
        $this->adresseEntreprise = $adresseEntreprise;
        return $this;
    }

    public function getCpentreprise(): ?int
    {
        return $this->cpentreprise;
    }

    public function setCpentreprise(int $cpentreprise): static
    {
        $this->cpentreprise = $cpentreprise;
        return $this;
    }

    public function getVilleEntreprise(): ?string
    {
        return $this->villeEntreprise;
    }

    public function setVilleEntreprise(string $villeEntreprise): static
    {
        $this->villeEntreprise = $villeEntreprise;

        return $this;
    }

    public function getTuteurEntreprise(): ?string
    {
        return $this->tuteurEntreprise;
    }

    public function setTuteurEntreprise(string $tuteurEntreprise): static
    {
        $this->tuteurEntreprise = $tuteurEntreprise;

        return $this;
    }

    public function getTelephoneEntreprise(): ?string
    {
        return $this->telephoneEntreprise;
    }

    public function setTelephoneEntreprise(string $telephoneEntreprise): static
    {
        $this->telephoneEntreprise = $telephoneEntreprise;

        return $this;
    }

    public function getMailEntreprise(): ?string
    {
        return $this->mailEntreprise;
    }

    public function setMailEntreprise(string $mailEntreprise): static
    {
        $this->mailEntreprise = $mailEntreprise;

        return $this;
    }
}
