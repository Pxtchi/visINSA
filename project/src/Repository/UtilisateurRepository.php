<?php

namespace App\Repository;

use App\Entity\Repondre;
use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * Classe UtilisateurRepository gère la BD de l'utilisateur
 */
class UtilisateurRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    /**
     * Constructeur de la classe
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }

    /**
     * Fonction upgradePassword pour changer le mot de passe d'un utilisateur
     *
     * @param PasswordAuthenticatedUserInterface $user
     * @param string $newHashedPassword
     * @return void
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Utilisateur) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * Fonction getJoueurs donne tous les utilisateurs de la BD
     *
     * @return array
     */
    public function getJoueurs() {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "Select u from App\Entity\Utilisateur u"
        );
        return $query->getResult();
    }

    /**
     * Fonction loadUserById donne l'utilisateur en fonction de son nom
     *
     * @param string $username
     * @return Utilisateur
     */
    public function loadUserById($username)
    {
        return $this->createQueryBuilder('u')
            ->select("u.username")
            ->where('u.id = :username')
            ->setParameter('username', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Fonction getEtape donne l'étape en fonction de son id
     *
     * @param integer $id
     * @return array
     */
    public function getEtape(int $id) {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "SELECT e from App\Entity\Etape e where e.idetape = :id"
        )->setParameter("id", $id);
        return $query->getResult();
    }

    /**
     * Fonction getAventureActuelle donne si c'est l'aventure actuelle d'un joueur
     *
     * @param integer $idEtape
     * @param string $nomAventure
     * @param integer $joueur
     * @return array
     */
    public function getAventureActuelle(int $idEtape, string $nomAventure, int $joueur) {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "SELECT a.aventureIsActuelle FROM App\Entity\Associer a JOIN App\Entity\Equipe e where a.idequipe = e.idequipe and a.nomaventure = :nomA and e.idJoueur = :idJ"
        )->setParameters(["nomA" => $nomAventure, "idJ" => $joueur]);
        return $query->getResult();
    }

    /**
     * Fonction getIdEquipes donne l'id de l'equipe du joueur
     *
     * @param integer $num
     * @param integer $idEquipe
     * @return array
     */
    public function getIdEquipes(int $num, int $idEquipe) {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "SELECT count(r.idetape) FROM App\Entity\Repondre r JOIN App\Entity\Etape et where et.placementaventure = :plac and et.idetape = r.idetape and r.idEquipe = :idE"
        )->setParameters(["plac" => $num, "idE" => $idEquipe]);
        return $query->getResult();
    }

    /**
     * Fonction getIdEquipe donne l'id de l'équipe en fonction de l'id du joueur et dun nom de l'aventure
     *
     * @param integer $idJoueur
     * @param string $nomAventure
     * @return array
     */
    public function getIdEquipe(int $idJoueur, string $nomAventure)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "SELECT a.idequipe FROM App\Entity\Associer a JOIN App\Entity\Equipe e where a.nomaventure = :nomA and e.idJoueur = :idJ and a.idequipe = e.idequipe"
        )->setParameters(["nomA" => $nomAventure, "idJ" => $idJoueur]);
        return $query->getResult();
    }
    
    /**
     * Fonction updtateRole change le role d'un utilisateur
     *
     * @param string $username
     * @param json $role
     * @return void
     */
    public function updtateRole($username, $role) {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "UPDATE App\Entity\Utilisateur u SET u.roles = :role WHERE u.username = :username"
        )->setParameters(["role" => json_encode([$role]), "username" => $username]);
        return $query->getResult();
    }

    /**
     * Fonction getUtilisateurs donne les noms d'utilisateur
     *
     * @return array
     */
    public function getUtilisateurs() {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "SELECT u.username FROM App\Entity\Utilisateur u"
        );
        return $query->getResult();
    }

    /**
     * Fonction getCorrect donne si la réponse de l'étape est correcte
     *
     * @param integer $idEquipe
     * @param integer $idEtape
     * @return array
     */
    public function getCorrect(int $idEquipe, int $idEtape)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "SELECT r.isCorrect FROM App\Entity\Repondre r where r.idetape = :idEtape and r.idEquipe = :idEquipe and r.isCorrect = 1"
        )->setParameters(["idEtape" => $idEtape, "idEquipe" => $idEquipe]);
        return $query->getResult();
    }

    /**
     * Fonction getEtapeFromAventure donne le nom, son placement, et les points de l'étape
     *
     * @param integer $idJoueur
     * @param string $idAventure
     * @return array
     */
    public function getEtapeFromAventure(int $idJoueur, string $idAventure){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "SELECT e.nometape, e.placementaventure, q.pointsquestion 
            FROM App\Entity\Aventure a JOIN App\Entity\Etape e JOIN App\Entity\Equipe eq JOIN App\Entity\Utilisateur u JOIN App\Entity\Question q JOIN App\Entity\Faire f
            WHERE q.idquestion = e.idquestion and a.nomaventure = e.nomaventure and eq.idJoueur = u.id and eq.idequipe = f.idequipe and f.nomaventure = a.nomaventure and u.id = :idJ and a.nomaventure = :nomA ORDER BY e.placementaventure"
        )->setParameters(["idJ" => $idJoueur, "nomA" => $idAventure]);
        return $query->getResult();
    }

    /**
     * Fonction getIsCorrectAventure donne le nom de l'étape et si elle est correcte
     *
     * @param integer $idJoueur
     * @param string $idAventure
     * @return array
     */
    public function getIsCorrectAventure(int $idJoueur, string $idAventure){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "SELECT e.nometape, r.isCorrect
            FROM App\Entity\Etape e JOIN App\Entity\Repondre r JOIN App\Entity\Equipe eq JOIN App\Entity\Utilisateur u
            WHERE eq.idJoueur = u.id and r.isCorrect = 1 and eq.idequipe = r.idEquipe and e.idetape = r.idetape and u.id = :idJ and e.nomaventure = :nomA
            ORDER BY e.placementaventure"
        )->setParameters(["idJ" => $idJoueur, "nomA" => $idAventure]);
        return $query->getResult();
    }

    /**
     * Fonction getIdEquipeFromAventureActuelle donne l'id de l'equipe pour un joueur si une aventure est en aventure actuelle
     *
     * @param integer $idJoueur
     * @return array
     */
    public function getIdEquipeFromAventureActuelle(int $idJoueur){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "SELECT e.idequipe
            FROM App\Entity\Utilisateur u JOIN App\Entity\Equipe e JOIN App\Entity\Associer a
            WHERE u.id = e.idJoueur and e.idequipe = a.idequipe and a.aventureIsActuelle = 1 and u.id = :id"
        )->setParameter(":id", $idJoueur);
        return $query->getResult();
    }

    /**
     * Fonction insertReponse qui insert dans le BD la réponse d'un joueur
     *
     * @param integer $idetape
     * @param integer $idEquipe
     * @param integer $numTentativePrec
     * @param string $reponse
     * @param boolean $isCorrect
     * @param ManagerRegistry $managerRegistry
     * @return void
     */
    public function insertReponse(int $idetape, int $idEquipe, int $numTentativePrec, string $reponse, bool $isCorrect, ManagerRegistry $managerRegistry)
    {
        $repondre = new Repondre();
        $repondre->setIdEtape($idetape);
        $repondre->setIdEquipe($idEquipe);
        $repondre->setNumTentatives($numTentativePrec);
        $repondre->setReponseuti($reponse);
        $repondre->setIsCorrect($isCorrect);
        $managerRegistry->getManager()->persist($repondre);
        $managerRegistry->getManager()->flush();
    }

    /**
     * Fonction getNumTentativePrec donne le numéro de la tentative de équipe et de l'étape
     *
     * @param integer $idetape
     * @param integer $idEquipe
     * @return array
     */
    public function getNumTentativePrec(int $idetape, int $idEquipe)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "SELECT max(r.numtentatives) FROM App\Entity\Repondre r where r.idetape = :idEtape and r.idEquipe = :idEquipe"
        )->setParameters(["idEtape" => $idetape, "idEquipe" => $idEquipe]);
        return $query->getResult();
    }

    /**
     * Fonction harmoniserReponse qui harmonise les réponses
     *
     * @param string $reponse
     * @return string
     */
    public function harmoniserReponse(string $reponse): string
    {
        $reponse = strtolower($reponse);
        $reponse = htmlentities($reponse, ENT_NOQUOTES, 'utf-8');
        $reponse = preg_replace('#&([A-za-z])(?:uml|circ|tilde|acute|grave|cedil|ring);#', '\1', $reponse);
        $reponse = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $reponse);
        $reponse = preg_replace('#&[^;]+;#', '', $reponse);
        $reponse = ltrim($reponse, " ");
        $reponse = rtrim($reponse, " ");
        return $reponse;
    }

    /**
     * Fonction verifReponse donne si la réponse est bonne
     *
     * @param string $reponseJoueur
     * @param string $bonneReponse
     * @return boolean
     */
    public function verifReponse(string $reponseJoueur, string $bonneReponse): bool
    {
        $reponseJoueur = $this->harmoniserReponse($reponseJoueur);
        $bonneReponse = $this->harmoniserReponse($bonneReponse);
        return $reponseJoueur == $bonneReponse;
    }

    /**
     * Fonction getEquipeFromAventureUtilisateur donne le nom, le score et le nom des joueurs en fonction de l'aventure et de l'id du joueur
     *
     * @param integer $idJoueur
     * @param string $aventure
     * @return array
     */
    public function getEquipeFromAventureUtilisateur(int $idJoueur, string $aventure){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "SELECT e.nomequipe, f.score, e.nomjoueurs
            FROM App\Entity\Equipe e JOIN App\Entity\Associer a JOIN App\Entity\Faire f
            WHERE e.idJoueur = :id and e.idequipe = f.idequipe and e.idequipe = a.idequipe and a.nomaventure = :ave"
        )->setParameters(["id" => $idJoueur, "ave" => $aventure]);
        return $query->getResult();
    }
}
