<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Creer;
use App\Entity\Etape;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreerFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++){
            $concepteur = new Utilisateur();
            $concepteur->setId($i + 10);
            $concepteur->setUsername("Concepteur $i");
            $concepteur->setmdpUti($this->hasher->hashPassword($concepteur, "MdpConcepteur$i"));
            $concepteur->setEmail("emailconcepteur$i@gmail.com");
            $concepteur->setRoles(["ROLE_CONCEPTEUR"]);
            $concepteur->setIsVerified(false);
            $manager->persist($concepteur);

            $etape = new Etape();
            $etape->setIdEtape($i);
            $etape->setNometape("Etape $i");
            $etape->setPosxqrcode(rand(0, 500) / 200);
            $etape->setPosyqrcode(rand(0, 500) / 200);
            $etape->setPlacementaventure($i);
            $etape->setEtatetape(true);
            $etape->setIdfilm($i);
            $etape->setIdquestion($i);
            $etape->setNomaventure("Aventure $i");
            $manager->persist($etape);

            $creer = new Creer();
            $creer->setIdConcepteur($concepteur->getId());
            $creer->setIdEtape($etape->getIdetape());
            $manager->persist($creer);
        }

        $manager->flush();
    }
}
