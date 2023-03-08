<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class JoueurFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++){
            $joueur = new Utilisateur();
            $joueur->setId($i + 20);
            $joueur->setUsername("Joueur $i");
            $joueur->setmdpUti($this->hasher->hashPassword($joueur, "MdpJoueur$i"));
            $joueur->setEmail("emailjoueur$i@gmail.com");
            $joueur->setRoles(["ROLE_USER"]);
            $joueur->setIsVerified(false);
            $manager->persist($joueur);
        }
        $manager->flush();
    }
}
