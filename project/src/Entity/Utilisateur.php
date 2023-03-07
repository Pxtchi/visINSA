<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomUti = null;

    #[ORM\Column(length: 255)]
    private ?string $mdpUti = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $roles = null;

    #[ORM\Column]
    private ?bool $isVerified = null;
    private $equipe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomUti(): ?string
    {
        return $this->nomUti;
    }

    public function setNomUti(string $nomUti): self
    {
        $this->nomUti = $nomUti;

        return $this;
    }

    public function getMdpUti(): ?string
    {
        return $this->mdpUti;
    }

    public function setMdpUti(string $mdpUti): self
    {
        $this->mdpUti = $mdpUti;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles(): ?string
    {
        return $this->roles;
    }

    public function setRoles(string $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function isIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
