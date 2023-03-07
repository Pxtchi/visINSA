<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="QUESTION")
 * @ORM\Entity
 */
class Question
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     
     */
    private $idquestion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="texteQuestion", type="string", length=100, nullable=true, unique=true)
     */
    private $textequestion;

    /**
     * @var int|null
     *
     * @ORM\Column(name="pointsQuestion", type="integer", nullable=true)
     */
    private $pointsquestion;

    public function getIdquestion(): ?int
    {
        return $this->idquestion;
    }

    /**
     * @param mixed $idquestion
     */
    public function setIdquestion(?int $idquestion)
    {
        $this->idquestion = $idquestion;
    }

    public function getTextequestion(): ?string
    {
        return $this->textequestion;
    }

    public function setTextequestion(?string $textequestion)
    {
        $this->textequestion = $textequestion;
    }

    public function getPointsquestion(): ?int
    {
        return $this->pointsquestion;
    }

    public function setPointsquestion(?int $pointsquestion)
    {
        $this->pointsquestion = $pointsquestion;
    }
}
