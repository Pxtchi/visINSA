<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Creer
 *
 * @ORM\Table(name="CREER")
 * @ORM\Entity
 */
class Creer
{
    /**
     * @var int|null
     *
     * @ORM\Column(name="nomConcepteur", type="integer", length=42, nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idConcepteur;

    /**
     * @var int|null
     *
     * @ORM\Column(name="idEtape", type="integer", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idetape;

    public function getIdConcepteur(): ?int
    {
        return $this->idConcepteur;
    }

    public function getIdetape(): ?int
    {
        return $this->idetape;
    }

    public function setIdConcepteur(?int $id)
    {
        $this->idConcepteur = $id;
    }

    public function setIdEtape(?int $id)
    {
        $this->idetape = $id;
    }

}
