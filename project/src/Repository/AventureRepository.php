<?php

namespace App\Repository;

use App\Entity\Aventure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Classe AventureRepository gère la BD pour les aventures
 */
class AventureRepository extends ServiceEntityRepository
{
    /**
     * Constructeur de la classe
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
        {
            parent::__construct($registry, Aventure::class);
        }
    
    /**
     * Fonction Aventuredisplay récupère le nom de l'aventure
     *
     * @return array
     */
    public function Aventuredisplay(): array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager-> createQuery(
            'SELECT a.nomaventure
            FROM    App\Entity\Aventure a
            ORDER BY a.nomaventure DESC'
            );
        return $query->getResult();
        
    }

    /**
     * Fonction getEtapes récupère l'id et le nom de l'étape en fonction du nom de l'aventure
     *
     * @param string|null $nom
     * @return array
     */
    public function getEtapes(?string $nom): array {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "Select distinct e.idetape, e.nometape from App\Entity\Etape e where e.nomaventure = :nomav"
        )->setParameter('nomav', $nom);
        return $query->getResult();
    }


    /**
     * Fonction getNbParticipants donne le nombre de participants pour une aventure
     *
     * @param string|null $ave
     * @return array
     */
    public function getNbParticipants(?string $ave) {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
          "Select count(a.idequipe) from App\Entity\Associer a where a.nomaventure = :nomav"
        )->setParameter('nomav', $ave);
        return $query->getResult();
    }

    /**
     * Fonction getNbEtapes donne le nombre d'étapes pour une aventure
     *
     * @param string|null $ave
     * @return array
     */
    public function getNbEtapes(?string $ave) {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "Select count(e.nomaventure) from App\Entity\Etape e where e.nomaventure = :nomav"
        )->setParameter('nomav', $ave);
        return $query->getResult();
    }

    /**
     * Fonction moyenneAventure donne la moyenne des scores pour l'aventure
     *
     * @param string|null $ave
     * @return array
     */
    public function moyenneAventure(?string $ave) {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "Select avg(f.score) from App\Entity\Faire f where f.nomaventure = :nomav"
        )->setParameter('nomav', $ave);
        return $query->getResult();
    }

    /**
     * Fonction scoreMaxAventure donne le score max pour une aventure
     *
     * @param string|null $ave
     * @return array
     */
    public function scoreMaxAventure(?string $ave) {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "Select sum(q.pointsquestion) from App\Entity\Question q JOIN App\Entity\Etape e where e.nomaventure = :nomav and e.idquestion = q.idquestion"
        )->setParameter('nomav', $ave);
        return $query->getResult();
    }

    /**
     * Fonction getAventureByIdJoueur donne le nom de l'aventure actuelle en fonction de l'id du joueur
     *
     * @param integer|null $idJoueur
     * @return array
     */
    public function getAventureByIdJoueur(?int $idJoueur) {
        $entityManager = $this->getEntityManager();
        $nomAv = $entityManager->createQuery(
            "Select a.nomaventure, a.aventureIsActuelle from App\Entity\Associer a JOIN App\Entity\Equipe e WHERE e.idJoueur = :ide and a.idequipe = e.idequipe"
        )->setParameter('ide', $idJoueur)->getResult();
        return $nomAv;
    }
}
