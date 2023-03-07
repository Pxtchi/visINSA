<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AssocierRepository;

/**
 * Associer
 *
 * @ORM\Table(name="ASSOCIER")
 * @ORM\Entity
 */
class Associer
{
    /**
     * @var string|null
     *
     * @ORM\Column(name="nomAventure", type="string", length=42, nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $nomaventure;

    /**
     * @var int|null
     *
     * @ORM\Column(name="idEquipe", type="integer", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idequipe;

    /**
     * @var int|null
     *
     * @ORM\Column(name="idAdmin", type="integer", length=42, nullable=true)
     */
    private $idAdmin;

    /**
     * @var boolean|false
     *
     * @ORM\Column(name="aventureIsActuelle", type="boolean", length=42, nullable=true)
     */
    private $aventureIsActuelle;

    public function getIdAdmin(): ?string
    {
        return $this->idAdmin;
    }

    public function getNomaventure(): ?string
    {
        return $this->nomaventure;
    }

    public function getIdequipe(): ?int
    {
        return $this->idequipe;
    }

    public function setIdAdmin(?int $id)
    {
        $this->idAdmin = $id;
    }

    public function setIdEquipe(?int $id)
    {
        $this->idequipe = $id;
    }

    public function setNomAventure(?string $nom)
    {
        $this->nomaventure = $nom;
    }

    public function setAventureIsActuelle(bool $aventureIsActuelle): void
    {
        $this->aventureIsActuelle = $aventureIsActuelle;
    }

    public function getAventureIsActuelle()
    {
        return $this->aventureIsActuelle;
    }

}
