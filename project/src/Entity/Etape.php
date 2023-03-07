<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;

/**
 * Etape
 *
 * @ORM\Table(name="ETAPE")
 * @ORM\Entity(repositoryClass=App\Repository\EtapesRepository::class)
 */
class Etape
{
    /**
     * @var int
     *
     * @ORM\Column(name="idEtape", type="integer", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idetape;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nomEtape", type="string", length=42, nullable=true)
     */
    private $nometape;

    /**
     * @var float|null
     *
     * @ORM\Column(name="posXQRCode", type="float", length=42, nullable=true)
     */
    private $posxqrcode;

    /**
     * @var float|null
     *
     * @ORM\Column(name="posYQRCode", type="float", length=42, nullable=true)
     */
    private $posyqrcode;

    /**
     * @var int|null
     *
     * @ORM\Column(name="placementAventure", type="integer", length=42, nullable=true)
     */
    private $placementaventure;

    /**
     * @var boolean|false
     *
     * @ORM\Column(name="etatEtape", type="boolean", length=42, nullable=false)
     */
    private $etatetape;

    /**
     * @var int|null
     *
     * @ORM\Column(name="idFilm", type="integer", nullable=true)
     */
    private $idfilm;

    /**
     * @var int|null
     *
     * @ORM\Column(name="idQuestion", type="integer", nullable=true)
     */
    private $idquestion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nomAventure", type="string", length=42, nullable=true)
     */
    private $nomaventure;

    public function getIdetape(): ?int
    {
        return $this->idetape;
    }

    public function getNometape(): ?string
    {
        return $this->nometape;
    }

    public function setNometape(?string $nometape)
    {
        $this->nometape = $nometape;
    }

    public function getPosxqrcode(): ?float
    {
        return $this->posxqrcode;
    }

    public function setPosxqrcode(?float $posxqrcode)
    {
        $this->posxqrcode = $posxqrcode;
    }

    public function getPosyqrcode(): ?float
    {
        return $this->posyqrcode;
    }

    public function setPosyqrcode(?float $posyqrcode)
    {
        $this->posyqrcode = $posyqrcode;
    }

    public function getPlacementaventure(): ?int
    {
        return $this->placementaventure;
    }

    public function setPlacementaventure(?int $placementaventure)
    {
        $this->placementaventure = $placementaventure;
    }

    public function getEtatetape(): ?bool
    {
        return $this->etatetape;
    }

    public function setEtatetape(?bool $etatetape)
    {
        $this->etatetape = $etatetape;
    }

    public function getIdfilm(): ?int
    {
        return $this->idfilm;
    }

    public function setIdfilm(?int $idfilm)
    {
        $this->idfilm = $idfilm;
    }

    public function getIdquestion(): ?int
    {
        return $this->idquestion;
    }

    public function setIdquestion(?int $idquestion)
    {
        $this->idquestion = $idquestion;
    }

    public function getNomaventure(): ?string
    {
        return $this->nomaventure;
    }

    public function setNomaventure(?string $nomaventure)
    {
        $this->nomaventure = $nomaventure;
    }

    public function setIdEtape(?int $id)
    {
        $this->idetape = $id;
    }

    public function __toString()
    {
        return $this->nometape;
    }
}
