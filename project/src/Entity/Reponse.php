<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReponseRepository::class)]
class Reponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $laReponse = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLaReponse(): ?string
    {
        return $this->laReponse;
    }

    public function setLaReponse(string $laReponse): self
    {
        $this->laReponse = $laReponse;

        return $this;
    }
}
