<?php

namespace App\Entity;
use App\Repository\AventureRepository;


use Doctrine\ORM\Mapping as ORM;

/**
 * Aventure
 *
 * @ORM\Table(name="AVENTURE")
 * @ORM\Entity(repositoryClass=App\Repository\AventureRepository::class)
 */
class Aventure
{
    /**
     * @var string
     *
     * @ORM\Column(name="nomAventure", type="string", length=42, nullable=true)
     * @ORM\Id
     */

    private $nomaventure;

    /**
     * @var string|null
     *
     * @ORM\Column(name="texteAventure", type="string", length=100, nullable=true)
     */
    private $texteaventure;

    /**
     * @var boolean|false
     *
     * @ORM\Column(name="etatAventure", type="boolean", length=42, nullable=false)
     */
    private $etataventure;

    public function setNomaventure(?string $nomaventure)
    {
        $this->nomaventure = $nomaventure;
    }

    public function getNomaventure(): ?string
    {
        return $this->nomaventure;
    }

    public function getTexteaventure(): ?string
    {
        return $this->texteaventure;
    }

    public function setTexteaventure(?string $texteaventure)
    {
        $this->texteaventure = $texteaventure;
    }

    public function getEtataventure(): bool
    {
        return $this->etataventure;
    }

    public function setEtataventure(?bool $etataventure)
    {
        $this->etataventure = $etataventure;
    }

    public function __toString()
    {
        return $this->nomaventure;
    }

}
