<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipeRepository::class)]
class Equipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomEquipe = null;

    #[ORM\Column(length: 255)]
    private ?string $nomsJoueurs = null;
    private $utilisateurs;
    private $tentatives;
    private $aventures;

    public function __construct() {
        $this->utilisateurs = new ArrayCollection();
        $this->tentatives = new ArrayCollection();
        $this->aventures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEquipe(): ?string
    {
        return $this->nomEquipe;
    }

    public function setNomEquipe(string $nomEquipe): self
    {
        $this->nomEquipe = $nomEquipe;

        return $this;
    }

    public function getNomsJoueurs(): ?string
    {
        return $this->nomsJoueurs;
    }

    public function setNomsJoueurs(string $nomsJoueurs): self
    {
        $this->nomsJoueurs = $nomsJoueurs;

        return $this;
    }
}
