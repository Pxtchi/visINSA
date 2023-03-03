<?php

namespace App\Entity;

use App\Repository\AventureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AventureRepository::class)]
class Aventure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $texteAventure = null;

    #[ORM\Column]
    private ?int $etatAventure = null;

    private $equipes;
    private $etapes;

    public function __construct() {
        $this->equipes = new ArrayCollection();
        $this->etapes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTexteAventure(): ?string
    {
        return $this->texteAventure;
    }

    public function setTexteAventure(string $texteAventure): self
    {
        $this->texteAventure = $texteAventure;

        return $this;
    }

    public function getEtatAventure(): ?int
    {
        return $this->etatAventure;
    }

    public function setEtatAventure(int $etatAventure): self
    {
        $this->etatAventure = $etatAventure;

        return $this;
    }
}
