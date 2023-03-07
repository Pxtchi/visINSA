<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Film
 *
 * @ORM\Table(name="FILM")
 * @ORM\Entity
 */
class Film
{
    /**
     *
     * @ORM\Column(name="idFilm", type="integer", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue()
     */
    private $idfilm;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nomfilm", type="string", length=42, nullable=true)
     */
    private $nomfilm;

    public function getIdfilm(): ?int
    {
        return $this->idfilm;
    }

    public function getNomfilm(): ?string
    {
        return $this->nomfilm;
    }

    public function setNomfilm(?string $nomfilm)
    {
        $this->nomfilm = $nomfilm;
    }

    /**
     * @param mixed $idfilm
     */
    public function setIdfilm(?int $idfilm)
    {
        $this->idfilm = $idfilm;
    }


}
