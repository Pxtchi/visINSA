<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Repondre
 *
 * @ORM\Table(name="REPONDRE")
 * @ORM\Entity
 */
class Repondre
{
    /**
     * @var int|null
     *
     * @ORM\Column(name="idEtape", type="integer", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idetape;

    /**
     * @var int|null
     *
     * @ORM\Column(name="idEquipe", type="integer", length=42, nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idEquipe;

    /**
     * @var int|null
     *
     * @ORM\Column(name="numTentatives", type="integer", length=42, nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $numtentatives;

    /**
     * @var string|null
     *
     * @ORM\Column(name="reponseUti", type="string", length=100, nullable=true)
     */
    private $reponseuti;

    /**
     * @var boolean|false
     *
     * @ORM\Column(name="isCorrect", type="boolean", length=42, nullable=false)
     */
    private $isCorrect;

    /**
     * @return bool
     */
    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }

    /**
     * @param bool $isCorrect
     */
    public function setIsCorrect(bool $isCorrect): void
    {
        $this->isCorrect = $isCorrect;
    }

    public function getIdetape(): ?int
    {
        return $this->idetape;
    }

    public function getIdEquipe(): ?int
    {
        return $this->idEquipe;
    }

    public function getNumtentatives(): ?int
    {
        return $this->numtentatives;
    }

    public function getReponseuti(): ?string
    {
        return $this->reponseuti;
    }

    public function setReponseuti(?string $reponseuti): self
    {
        $this->reponseuti = $reponseuti;

        return $this;
    }

    public function setIdEtape(?int $id)
    {
        $this->idetape = $id;
    }

    public function setIdEquipe(?int $id)
    {
        $this->idEquipe = $id;
    }

    public function setNumTentatives(?int $num)
    {
        $this->numtentatives = $num;
    }

}
