<?php


namespace App\Repository;

use App\Entity\Etape;
use App\Entity\Associer;
use App\Entity\Repondre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Classe EtapesRepository gère la BD pour les étapes
 */
class EtapesRepository extends ServiceEntityRepository
{
    /**
     * Constructeur de la classe
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etape::class);
    }

    /**
     * Fonction getReponsesEtape donne les réponses pour une étape
     *
     * @param integer|null $idetape
     * @return array
     */
    public function getReponsesEtape(?int $idetape): array {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'Select r.reponseuti FROM App\Entity\Repondre r where r.idetape = :idEtape'
        )->setParameter('idEtape', $idetape);
        return $query->getResult();
    }

    /**
     * Fonction getAventureActuelle donne l'aventure actuelle pour le joueur courant
     *
     * @param integer $idJoueurCourant
     * @return array
     */
    public function getAventureActuelle(int $idJoueurCourant) {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "Select a.nomaventure FROM App\Entity\Associer a JOIN App\Entity\Equipe e where a.aventureIsActuelle = 1 and e.idJoueur = :idJoueur and a.idequipe = e.idequipe"
        )->setParameter('idJoueur', $idJoueurCourant);
        return $query->getResult();
    }

    /**
     * Fonction getPositionsEtapes donne les coordonnées des étapes pour une aventure
     *
     * @param int $joueurCourant
     * @return array
     */
    public function getPositionsEtapes($joueurCourant) {
        $nomAventure = $this->getAventureActuelle($joueurCourant);
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'Select e.posxqrcode, e.posyqrcode, e.nometape FROM App\Entity\Etape e where e.nomaventure = :nomAventure'
        )->setParameter('nomAventure', $nomAventure);
        return $query->getResult();
    }
}