<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Reponse;


class ReponseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++){
            $reponse = new Reponse();
            $reponse->setIdReponse($i);
            $reponse->setLareponse("La réponse.");
            $reponse->setIdQuestion($i);
            $manager->persist($reponse);
        }

        $manager->flush();
    }
}
