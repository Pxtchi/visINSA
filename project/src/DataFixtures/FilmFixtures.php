<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Film;


class FilmFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++){
            $film = new Film();
            $film->setIdfilm($i);
            $film->setNomfilm("Film$i.mp4");
            $manager->persist($film);
        }

        $manager->flush();
    }
}
