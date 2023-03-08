<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Associer;
use App\Entity\Aventure;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AssocierFixtures extends Fixture
{

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++){
            $admin = new Utilisateur();
            $admin->setId($i);
            $admin->setUsername("Admin $i");
            $admin->setmdpUti($this->hasher->hashPassword($admin, "MdpAdmin$i"));
            $admin->setEmail("emailadmin$i@gmail.com");
            $admin->setRoles(["ROLE_ADMIN"]);
            $admin->setIsVerified(false);
            $manager->persist($admin);

            $aventure = new Aventure();
            $aventure->setNomaventure("Aventure $i");
            $aventure->setTexteaventure("Texte de l'aventure $i");
            $aventure->setEtataventure(true);
            $manager->persist($aventure);

            $associer = new Associer();
            $associer->setIdAdmin($admin->getId());
            $associer->setNomAventure($aventure->getNomaventure());
            $associer->setIdEquipe($i);
            $associer->setAventureIsActuelle(true);
            $manager->persist($associer);
        }

        $manager->flush();
    }
}
