<?php

namespace App\Controller;


use App\Entity\Etape;
use App\Entity\Utilisateur;
use App\Entity\Associer;
use App\Entity\Film;
use App\Entity\Question;
use App\Entity\Reponse;
use App\Entity\Aventure;
use App\Form\QuestionnaireForm;
use App\Repository\AventureRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\FinRepository;
use App\Entity\Faire;
use App\Entity\Equipe;

/**
 * classe JoueurController gère le scan et toutes les pages du joueur sauf la carte
 */
class JoueurController extends AbstractController
{
    /**
     * Redirige sur la page scan du joueur
     * @return Response
     */
    public function scan()
    {
        return $this->render('Joueur/scan.html.twig', [
            'titre' => "Scan"
        ]);
    }

    /**
     * Gère toutes les vérifications et les redirections associées lors d'un scan d'un QR-code
     * @param UtilisateurRepository $utilisateurRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/joueur/questionnaire", name="questionnaire", methods={"POST"})
     */
    public function verifScan(UtilisateurRepository $utilisateurRepository)
    {
        $idetape = $_POST["id"];
        $etape = $utilisateurRepository->getEtape(intval($idetape));
        // regarde si le QR-code est complètement différent de la norme qu'on utilise
        if (sizeof($etape) == 0) {
            echo "<script>alert(\"Le QR-code n'appartient pas à l'aventure actuelle !\")</script>";
            return $this->render('Joueur/scan.html.twig', [
                'titre' => "Scan"
            ]);
        }
        $nomAventure = $etape[0]->getNomaventure();
        $idJoueur = $this->getUser()->getId();
        //regarde si l'etape scannée est bien de l'aventure en cours
        $res = $utilisateurRepository->getAventureActuelle(intval($idetape), $nomAventure, $idJoueur);
        if (sizeof($res) == 0 || $res[0]["aventureIsActuelle"] == 0) {
            echo "<script>alert(\"Le QR-code n'appartient pas à l'aventure actuelle !\")</script>";
            return $this->render('Joueur/scan.html.twig', [
                'titre' => "Scan"
            ]);
        }
        $numEtape = $etape[0]->getPlacementaventure();
        $idEquipe = $utilisateurRepository->getIdEquipe($idJoueur, $nomAventure);
        //regarde si la réponse de l'étape a déjà été répondue correctement
        $correct = $utilisateurRepository->getCorrect($idEquipe[0]["idequipe"], $etape[0]->getIdetape());
        if (sizeof($correct) != 0) {
            echo "<script>alert(\"Vous avez déjà répondu correctement à ce QR-Code !\")</script>";
            return $this->render('Joueur/scan.html.twig', [
                'titre' => "Scan"
            ]);
        }
        // regarde si ce n'est pas la 1ère étape de l'aventure
        if ($numEtape != 1) {
            $res = $utilisateurRepository->getIdEquipes($numEtape - 1, $idEquipe[0]["idequipe"]);
            //regarde si le qr-code précédent a été fait ou non
            if ($res[0][1] != 1) {
                echo "<script>alert(\"Ce QR-code doit être effectué plus tard. Revenez quand vous aurez trouvé les précédents !\")</script>";
                return $this->render('Joueur/scan.html.twig', [
                    'titre' => "Scan"
                ]);
            }
        }
        return $this->redirectToRoute("questionnaireVue", [], 308);
    }

    /**
     * Gère la page et le formulaire de la page après le scan pour répondre à un questionnaire
     * @param Request $request
     * @param UtilisateurRepository $utilisateurRepository
     * @param ManagerRegistry $doctrine
     * @param FinRepository $finRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/joueur/questionnaire/vue", name="questionnaireVue", methods={"POST"})
     */
    public function questionnaireVue(Request $request, UtilisateurRepository $utilisateurRepository, ManagerRegistry $doctrine, FinRepository $finRepository) {
        $form = $this->createForm(QuestionnaireForm::class, [""]);
        //récupère l'id de l'étape passée en POST
        if (isset($_POST["id"])) {
            $idetape = $_POST["id"];
            $form = $this->createForm(QuestionnaireForm::class, [$idetape]);
        }
        // formulaire du questionnaire si le bouton de validation est appuyé
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // récupération des données utiles
            $idetape = $form->getData()["idEtape"];
            $etape = $utilisateurRepository->getEtape($idetape)[0];
            $idJoueur = $this->getUser()->getId();
            $idQuestion = $etape->getIdquestion();
            $nomAventure = $etape->getNomaventure();
            $idEquipe = $utilisateurRepository->getIdEquipe($idJoueur, $nomAventure);
            $numTPrec = $utilisateurRepository->getNumTentativePrec($idetape, $idEquipe[0]["idequipe"])[0][1];
            $bonneReponse = $doctrine->getRepository(Reponse::class)->findOneBy(["idquestion" => $idQuestion])->getLareponse();
            $repJoueur = $form->get("reponse")->getData();
            $verif = $utilisateurRepository->verifReponse($repJoueur, $bonneReponse);

            $idDerniereEtape = $finRepository->getIdDerniereEtape($nomAventure)[0]["idetape"];

            // si la reponse est la même que celle attendue
            if ($verif) {
                // ajoute le nombre de points et ajoute la réponse dans la base
                $faire = $doctrine->getRepository(Faire::class)->findOneBy(["idequipe" => $idEquipe, "nomaventure" => $nomAventure]);
                $point = $doctrine->getRepository(Question::class)->findOneBy([ "idquestion" => $etape->getIdquestion()])->getPointsquestion();
                $faire->setScore($faire->getScore() + $point);
                $doctrine->getManager()->flush();
                $utilisateurRepository->insertReponse($idetape, $idEquipe[0]["idequipe"], $numTPrec + 1, $repJoueur, $verif, $doctrine);
                $reponduDerniereEtape = $finRepository->derniereEtapeRepondue($idEquipe[0]["idequipe"], $idDerniereEtape)[0][1];
                // regarde si c'était la dernière étape et redirige en fonction
                if ($reponduDerniereEtape > 0){
                    return $this->redirectToRoute("home", ["OK" => true, "fin" => true, "nomAve" => $nomAventure]);
                }
                return $this->redirectToRoute("home", ["OK" => true]);
            }
            // insert dans la base en tant de réponse non bonne avec une tentative
            $utilisateurRepository->insertReponse($idetape, $idEquipe[0]["idequipe"], $numTPrec + 1, $repJoueur, $verif, $doctrine);
            echo "<script>alert(\"Dommage, ce n'était pas la bonne réponse ! Essayez à nouveau !\")</script>";
            $reponduDerniereEtape = $finRepository->derniereEtapeRepondue($idEquipe[0]["idequipe"], $idDerniereEtape)[0][1];
            // regarde si c'était la dernière étape et redirige en fonction
            if ($reponduDerniereEtape > 0){
                return $this->redirectToRoute("home", ["juste" => true, "fin" => true, "nomAve" => $nomAventure]);
            }
        }
        // récupération des données utiles pour l'affichage de la page
        $etape = $utilisateurRepository->getEtape($idetape)[0];
        $idQuestion = $etape->getIdquestion();
        $idFilm = $etape->getIdfilm();
        $texteQuestion = $doctrine->getRepository(Question::class)->findOneBy(["idquestion" => $idQuestion])->getTextequestion();
        $nomFilm = $doctrine->getRepository(Film::class)->findOneBy(["idfilm" => $idFilm])->getNomfilm();
        return $this->renderForm('Joueur/questionnaire.html.twig', [
            'titre' => "Questionnaire",
            'form' => $form,
            "nomFilm" => $nomFilm,
            "texteQuestion" => $texteQuestion
        ]);
    }

    /**
     * Gère la page qui liste toutes les aventures du joueur
     * @param AventureRepository $ave
     * @return Response
     */
    public function adv(AventureRepository $ave)
    {
        $user = $this->getUser()->getId();
        $aventures= $ave->getAventureByIdJoueur($user);
        return $this->render('Joueur/aventure.html.twig', [
            'aventures'=>$aventures,
            'titre' => 'Aventure'
        ]);
    }

    /**
     * Gère la page qui classe les équipes pour l'aventure en cours
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function rank(ManagerRegistry $doctrine)
    {
        $scores=$doctrine->getRepository(Faire::class)->findBy([],["score"=>"DESC"]);
        $teams=$doctrine->getRepository(Equipe::class)->findAll();
        return $this->render('Joueur/rank.html.twig', [
            'controller_name' => 'RankController',
            "teams"=>$teams,"scores"=>$scores,
            'titre'=>'Classement'
        ]);
    }

    /**
     * Gère la page expliquant toutes les missions, les étapes... pour une aventure consultée
     * @param Request $request
     * @param UtilisateurRepository $utilisateurRepository
     * @param ManagerRegistry $doctrine
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function mission(Request $request, UtilisateurRepository $utilisateurRepository, ManagerRegistry $doctrine)
    {
        $aventure = $doctrine->getRepository(Aventure::class)->findOneBy(["nomaventure" => $request->get("idAventure")]);
        $rep = $utilisateurRepository->getEtapeFromAventure($this->getUser()->getId(), $request->get("idAventure"));
        $etapeIsCorrect = $utilisateurRepository->getIsCorrectAventure($this->getUser()->getId(), $request->get("idAventure"));
        $equipe = $utilisateurRepository->getEquipeFromAventureUtilisateur($this->getUser()->getId(), $request->get("idAventure"));
        if(sizeof($rep) > 0){
            return $this->render('Joueur/mission.html.twig', [
                'titre'=> 'Mission',
                'aventure' => $aventure,
                'etapes' => $rep,
                'is' => $etapeIsCorrect,
                'equipe' => $equipe[0]
            ]);
        }
        return $this->redirectToRoute("adv");
        
    }

    /**
     * Gère le changement de l'aventure actuelle avec son affichage sur la page mission
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @param UtilisateurRepository $utilisateur
     * @return Response
     */
    public function setIsActuelle(Request $request, ManagerRegistry $doctrine, UtilisateurRepository $utilisateur){
        $aventureActuelle = $doctrine->getRepository(Associer::class)->findOneBy(["aventureIsActuelle" => 1, "idequipe" => $utilisateur->getIdEquipeFromAventureActuelle($this->getUser()->getId())[0]['idequipe']]);
        if($aventureActuelle != null){
            $aventureActuelle->setAventureIsActuelle(0);
            $doctrine->getManager()->flush();
        }
        $idEquipe = $utilisateur->getIdEquipe($this->getUser()->getId(), $request->get("aventure"));
        $associerNouv = $doctrine->getRepository(Associer::class)->findOneBy(["nomaventure" => $request->get("aventure"), "idequipe" => $idEquipe[0]['idequipe']]);
        $associerNouv->setAventureIsActuelle(1);
        $doctrine->getManager()->flush();

        $retour = [];
        $retour["old"] =  $aventureActuelle->getNomAventure();
        $retour["new"] = $associerNouv->getNomAventure();

        return new Response(json_encode($retour));

    }


    /**
     * Accueil de base de symfony
     * @Route("/Home", name="homeDeco")
     */
    public function homeDeco()
    {
        return $this->render('Home/accueil.php.twig',[
        ]);
    }
    
}
