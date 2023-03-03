<?php

namespace App\Entity;

use App\Repository\EtapeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtapeRepository::class)]
class Etape
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomEtape = null;

    #[ORM\Column]
    private ?int $posXQRCode = null;

    #[ORM\Column]
    private ?int $posYQRCode = null;

    #[ORM\Column]
    private ?int $placementAventure = null;

    #[ORM\Column]
    private ?int $etatEtape = null;
    private $aventure;
    private $questions;
    private $films;
    private $tentatives;

    public function __construct(){
        $this->questions = new ArrayCollection();
        $this->films = new ArrayCollection();
        $this->tentatives = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEtape(): ?string
    {
        return $this->nomEtape;
    }

    public function setNomEtape(string $nomEtape): self
    {
        $this->nomEtape = $nomEtape;

        return $this;
    }

    public function getPosXQRCode(): ?int
    {
        return $this->posXQRCode;
    }

    public function setPosXQRCode(int $posXQRCode): self
    {
        $this->posXQRCode = $posXQRCode;

        return $this;
    }

    public function getPosYQRCode(): ?int
    {
        return $this->posYQRCode;
    }

    public function setPosYQRCode(int $posYQRCode): self
    {
        $this->posYQRCode = $posYQRCode;

        return $this;
    }

    public function getPlacementAventure(): ?int
    {
        return $this->placementAventure;
    }

    public function setPlacementAventure(int $placementAventure): self
    {
        $this->placementAventure = $placementAventure;

        return $this;
    }

    public function getEtatEtape(): ?int
    {
        return $this->etatEtape;
    }

    public function setEtatEtape(int $etatEtape): self
    {
        $this->etatEtape = $etatEtape;

        return $this;
    }
}
