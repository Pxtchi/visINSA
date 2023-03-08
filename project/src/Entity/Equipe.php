<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Equipe
 *
 * @ORM\Table(name="EQUIPE")
 * @ORM\Entity
 */
class Equipe
{
    /**
     * @var int|null
     *
     * @ORM\Column(name="idEquipe", type="integer", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idequipe;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nomEquipe", type="string", length=42, nullable=true)
     */
    private $nomequipe;

    /**
     * @var int|null
     *
     * @ORM\Column(name="idJoueur", type="integer", nullable=true)
     */
    private $idJoueur;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nomJoueurs", type="string", length=50, nullable=true)
     */
    private $nomjoueurs;

    public function getIdequipe(): ?int
    {
        return $this->idequipe;
    }

    public function getNomequipe(): ?string
    {
        return $this->nomequipe;
    }

    public function setNomequipe(?string $nomequipe)
    {
        $this->nomequipe = $nomequipe;
    }

    public function getIdJoueur(): ?int
    {
        return $this->idJoueur;
    }

    public function setIdJoueur(?int $id)
    {
        $this->idJoueur = $id;
    }

    public function setIdEquipe(?int $id)
    {
        $this->idequipe = $id;
    }

    public function getNomjoueurs(): ?string
    {
        return $this->nomjoueurs;
    }

    public function setNomjoueurs(?string $nomjoueurs)
    {
        $this->nomjoueurs = $nomjoueurs;
    }

}
