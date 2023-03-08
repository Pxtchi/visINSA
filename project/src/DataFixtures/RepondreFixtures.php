<?php

namespace App\DataFixtures;

use App\Entity\Equipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Repondre;
use App\Entity\Tentatives;

class RepondreFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++){
            $equipe = new Equipe();
            $equipe->setIdEquipe($i);
            $equipe->setNomequipe("Equipe $i");
            $equipe->setIdJoueur($i + 20);
            $equipe->setNomjoueurs("j$i,j".($i+1));
            $manager->persist($equipe);

            $tentatives = new Tentatives();
            $tentatives->setNumtentatives(1);
            $manager->persist($tentatives);

            $repondre = new Repondre();
            $repondre->setIdEtape($i);
            $repondre->setIdEquipe($equipe->getIdequipe());
            $repondre->setNumTentatives($tentatives->getNumtentatives());
            $repondre->setReponseuti("Réponse de l'equipe " . $equipe->getIdequipe());
            $repondre->setIsCorrect(false);
            $manager->persist($repondre);
        }

        $manager->flush();
    }
}
