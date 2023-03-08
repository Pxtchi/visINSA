<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Faire;


class FaireFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++){
            $faire = new Faire();
            $faire->setIdEquipe($i);
            $faire->setNomAventure("Aventure $i");
            $faire->setScore(random_int(1, 3000));
            $manager->persist($faire);
        }

        $manager->flush();
    }
}
