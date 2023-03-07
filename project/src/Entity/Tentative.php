<?php

namespace App\Entity;

use App\Repository\TentativeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TentativeRepository::class)]
class Tentative
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    private $equipe;
    private $etape;

    public function getId(): ?int
    {
        return $this->id;
    }
}
