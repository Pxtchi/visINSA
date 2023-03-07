<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Faire
 *
 * @ORM\Table(name="FAIRE")
 * @ORM\Entity
 */
class Faire
{
    /**
     * @var int|null
     *
     * @ORM\Column(name="idEquipe", type="integer", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idequipe;

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
     * @ORM\Column(name="score", type="integer", length=42, nullable=true)
     */
    private $score;

    public function getIdequipe(): ?int
    {
        return $this->idequipe;
    }

    public function getNomaventure(): ?string
    {
        return $this->nomaventure;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score)
    {
        $this->score = $score;
    }

    public function setIdEquipe(?int $id)
    {
        $this->idequipe = $id;
    }

    public function setNomAventure(?string $nom)
    {
        $this->nomaventure = $nom;
    }


}
