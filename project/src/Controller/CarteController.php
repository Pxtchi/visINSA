<?php


namespace App\Controller;


use App\Entity\Associer;
use App\Repository\EtapesRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Classe CarteController gère l'affichage de la carte avec les markers de l'aventure actuelle pour le joueur
 */
class CarteController extends AbstractController
{
    /**
     * Récupère les markers pour chaque étape de l'aventure en cours. Gère les alerts en fonction de la réponse
     * de l'équipe à une étape
     * @param EtapesRepository $etapesRepository
     * @param Request $request
     * @param UtilisateurRepository $utilisateurRepository
     * @return Response
     */
    public function getMarkers(EtapesRepository $etapesRepository, Request $request, UtilisateurRepository $utilisateurRepository): Response {
        $idUser = $this->getUser()->getId();
        $positions = $etapesRepository->getPositionsEtapes($idUser);
        $repQRCodeBonne = $request->get("OK");
        if ($repQRCodeBonne == "") {
            $repQRCodeBonne = "false";
        }
        $finAve = $request->get("fin");
        $nomAve = $request->get("nomAve");
        if ($finAve == "") {
            $finAve = "false";
        }
        $pasJuste = $request->get("juste");
        if ($pasJuste == "") {
            $pasJuste = "false";
        }
        return $this->render('Joueur/home.html.twig', [
            'titre' => 'Carte',
            'positions' => $positions,
            "OK" => $repQRCodeBonne,
            "fin" => $finAve,
            "nomAventure" => $nomAve,
            "pasJuste" => $pasJuste
        ]);
    }
}