<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tentatives
 *
 * @ORM\Table(name="TENTATIVES")
 * @ORM\Entity
 */
class Tentatives
{
    /**
     * @var int|null
     *
     * @ORM\Column(name="numTentatives", type="integer", length=42, nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $numtentatives;

    public function getNumtentatives(): ?string
    {
        return $this->numtentatives;
    }

    public function setNumtentatives(?int $numtentatives)
    {
        $this->numtentatives = $numtentatives;
    }

}
