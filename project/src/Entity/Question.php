<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $texteQuestion = null;

    #[ORM\Column(length: 255)]
    private ?string $pointsQuestion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTexteQuestion(): ?string
    {
        return $this->texteQuestion;
    }

    public function setTexteQuestion(string $texteQuestion): self
    {
        $this->texteQuestion = $texteQuestion;

        return $this;
    }

    public function getPointsQuestion(): ?string
    {
        return $this->pointsQuestion;
    }

    public function setPointsQuestion(string $pointsQuestion): self
    {
        $this->pointsQuestion = $pointsQuestion;

        return $this;
    }
}
