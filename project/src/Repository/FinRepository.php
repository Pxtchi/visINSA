<?php

namespace App\Repository;

use App\Entity\Repondre;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Classe FinRepository consulte la BD pour afficher le message de fin d'aventure
 */
class FinRepository extends \Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository
{
    /**
     * Constructeur de la classe
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Repondre::class);
    }

    /**
     * Fonction getIdDerniereEtape donne l'id de la dernière étape en fonction de l'aventure
     *
     * @param string $nomAventure
     * @return array
     */
    public function getIdDerniereEtape(string $nomAventure) {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "SELECT max(e.placementaventure) FROM App\Entity\Etape e where e.nomaventure = :nom"
        )->setParameter("nom", $nomAventure);
        $max = $query->getResult()[0][1];
        $query = $entityManager->createQuery(
            "SELECT e.idetape FROM App\Entity\Etape e where e.nomaventure = :nom and e.placementaventure = :place"
        )->setParameters(["nom" => $nomAventure, "place" => $max]);
        return $query->getResult();
    }

    /**
     * Fonction derniereEtapeRepondue donne le nombre de tentative de l'étape en fonction du joueur
     *
     * @param integer $idEquipe
     * @param integer $idEtape
     * @return array
     */
    public function derniereEtapeRepondue(int $idEquipe, int $idEtape) {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "SELECT count(r) from App\Entity\Repondre r where r.idEquipe = :idequipe and r.idetape = :idetape"
        )->setParameters(["idequipe" => $idEquipe, "idetape" => $idEtape]);
        return $query->getResult();
    }
}