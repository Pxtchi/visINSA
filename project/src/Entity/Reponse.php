<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reponse
 *
 * @ORM\Table(name="REPONSE")
 * @ORM\Entity
 */
class Reponse
{
    /**
     * @var int|null
     *
     * @ORM\Column(name="idReponse", type="integer", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idreponse;

    /**
     * @var string
     *
     * @ORM\Column(name="laReponse", type="string", length=50, nullable=true)
     */
    private $lareponse;

    /**
     * @var int|null
     *
     * @ORM\Column(name="idquestion", type="integer", nullable=true)
     */
    private $idquestion;


    public function getIdreponse(): ?int
    {
        return $this->idreponse;
    }

    public function getLareponse(): ?string
    {
        return $this->lareponse;
    }

    public function setLareponse(?string $lareponse)
    {
        $this->lareponse = $lareponse;
    }

    public function setIdReponse(?int $id)
    {
        $this->idreponse = $id;
    }

    public function setIdQuestion(?int $id)
    {
        $this->idquestion = $id;
    }

}
