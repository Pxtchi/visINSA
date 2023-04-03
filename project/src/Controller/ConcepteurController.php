<?php
namespace App\Controller;

use App\Form\QuestionForm;
use App\Form\AventureForm;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Aventure;
use App\Entity\Etape;
use App\Entity\Question;
use App\Entity\Film;
use App\Form\EtapesForm;
use App\Repository\AventureRepository;
use App\Repository\EtapeRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\QrForm;
use App\Services\QrcodeService;
use Symfony\Component\Validator\Constraints\Choice;

class ConcepteurController extends AbstractController
{
    #[Route('/concepteur', name: 'concepteur')]
    public function concepteur(ManagerRegistry $doctrine): Response
    {
        $aventures = $doctrine->getRepository(Aventure::class)->findAll();
        return $this->render('concepteur/concepteur.html.twig', [
            'aventures' => $aventures,
            'titre' => 'Concepteur',
        ]);
    }

    public function modif_aventure(ManagerRegistry $doctrine): Response
    {
        $titre = "Modifier Aventure";
        $nomAventure = $_GET['aventure'];
        $aventure = $doctrine->getRepository(Aventure::class)->find($nomAventure);
       
        $etapes = $doctrine->getRepository(Etape::class)->findBy(['nomaventure' => $nomAventure]);
        $nomEtapes=[];
        $numEtapes=[];
        foreach ($etapes as $elem) {
            $nomEtapes[] = $elem->getNometape();
            $numEtapes[] = $elem->getPlacementaventure();
        }

        $etapesAll = $doctrine->getRepository(Etape::class)->findBy(['nomaventure' => null]);
        $nomEtapesAll = [];
        foreach ($etapesAll as $elem) {
            $nomEtapesAll[] = $elem->getNomEtape();
        }

        $send = $_GET['send'];
        if ($send == 1) {
            $aventure->setTexteaventure($_POST['texteAventure']);
            $aventure->setEtataventure($_POST['etatAventure']);
        }

        $doctrine->getManager()->flush();
        
        return $this->render('Concepteur/modif_aventure.html.twig',['titre' => $titre,'nomAventure' => $nomAventure,'etatAventure' => $aventure->getEtataventure(),
                                                                'texteAventure'=> $aventure->getTexteaventure(),'etapes' =>  $nomEtapes,'etapesAll' => $nomEtapesAll, 'numEtapes' => $numEtapes]);
    }

    public function addEtape(ManagerRegistry $doctrine): Response
    {
        $nomAventure = $_GET['aventure'];
        if (!isset($_POST['etapeAll'])) {
            return $this->redirectToRoute('concepteur_home');
        }
        $listeEtapeIntoAventure = $doctrine->getRepository(Etape::class)->findBy(['nomaventure' => $nomAventure]);
        $etapeToAdd = $doctrine->getRepository(Etape::class)->findBy(['nometape' => $_POST['etapeAll']])[0];
        if (in_array($etapeToAdd,$listeEtapeIntoAventure)) {
            return $this->redirectToRoute('concepteur_home');
        }
        $etapeToAdd->setNomaventure($nomAventure);
        $etapeToAdd->setPlacementaventure(count($listeEtapeIntoAventure)+1);
        $doctrine->getManager()->flush();
        return $this->redirectToRoute('page_modification_aventure',['aventure'=>$nomAventure,'send'=>0]);
    }

    /**
     * Cette fonction permet de supprimer une étape déjà associé à une aventure depuis la page modifier aventure
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function delEtape(ManagerRegistry $doctrine): Response
    {
        if (!isset($_GET['etape'])) {
            return $this->redirectToRoute('concepteur_home');
        }
        $etapeToDel = $doctrine->getRepository(Etape::class)->findBy(['nometape' => $_GET['etape']])[0];
        $nomAventure = $etapeToDel->getNomaventure();
        $listeEtapeIntoAventure = $doctrine->getRepository(Etape::class)->findBy(['nomaventure' => $nomAventure]);
        $numE = $etapeToDel->getPlacementaventure();
        foreach($listeEtapeIntoAventure as $elem) {
            if ($elem->getPlacementaventure() > $numE) {
                $elem->setPlacementaventure($elem->getPlacementaventure()-1);
            }
        }
        $etapeToDel->setNomaventure(null);
        $etapeToDel->setPlacementaventure(null);
        $doctrine->getManager()->flush();

        return $this->redirectToRoute('page_modification_aventure',['aventure'=>$_GET['aventure'],'send'=>0]);
     
    } 

    /**
     * Cette fonction permet de supprimer une aventure depuis la page modifier aventure
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function delAventure(ManagerRegistry $doctrine): Response
    {
        if (!isset($_GET['aventure'])) {
            return $this->redirectToRoute('concepteur_home');
        }
        $adventureToDel = $doctrine->getRepository(Aventure::class)->find($_GET['aventure']);
        $listeEtapeIntoAventure = $doctrine->getRepository(Etape::class)->findBy(['nomaventure' => $_GET['aventure']]);
        foreach ($listeEtapeIntoAventure as $elem) {
            $elem->setPlacementaventure(null);
            $elem->setNomaventure(null);
        }
        $doctrine->getManager()->remove($adventureToDel);
        $doctrine->getManager()->flush();
        return $this->redirectToRoute('concepteur_home');
    }

    /*
    * Cette fonction permet de supprimer une étape
    * @param ManagerRegistry $doctrine
    * @return Response
    */
   public function deleteEtape(ManagerRegistry $doctrine): Response {        
       if (isset($_POST['deleteEtape']) && $_POST['deleteEtape'] != "") {
           print($_POST['deleteEtape']);
           $etape = $doctrine->getRepository(Etape::class)->find($_POST['deleteEtape']);
           $doctrine->getManager()->remove($etape);
           $doctrine->getManager()->flush();        
           return $this->redirectToRoute('page_creation_etape');
       }
       return $this->redirectToRoute('concepteur_home');
   }
   

    public function modif_question(EntityManagerInterface $entityManager, Request $request): Response
    {
        $question = new Question();        
        $form = $this->createForm(QuestionForm::class, $question);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($question);
            $entityManager->flush();

            return $this->redirectToRoute('concepteur_home');
        }
        return $this->render('concepteur/modif_question.html.twig', [
            'titre' => 'Création questions',
            'form' => $form->createView(),
        ]);
    }

    public function modif_etape(EntityManagerInterface $entityManager, Request $request, QrcodeService $qrcodeService): Response
    {
        $etape = new Etape();
        $form = $this->createForm(EtapesForm::class, $etape);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $etape->setEtatetape(1);

            $entityManager->persist($etape);
            $entityManager->flush();

            return $this->redirectToRoute('concepteur_home');
        }

        $qrCode = null;
        $formqr = $this->createForm(QrForm::class, null);
        $formqr->handleRequest($request);

        if ($formqr->isSubmitted() && $formqr->isValid()) {
            $data = $formqr->getData();
            $etapeqr = $data['etape'];
            $qrCode = $qrcodeService->qrcode($etapeqr->getIdetape());
        }

        return $this->render('concepteur/modif_etape.html.twig', [
            'form' => $form->createView(),
            'titre' => 'Création étapes',
            'formqr' => $formqr->createView(),
            'qrCode' => $qrCode
        ]);


    }

    public function creer_aventure(EntityManagerInterface $entityManager, Request $request): Response
    {
        $aventure = new Aventure();
        $form = $this->createForm(AventureForm::class, $aventure);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($aventure);
            $entityManager->flush();

            return $this->redirectToRoute('concepteur_home');
        }

        return $this->render('concepteur/creer_aventure.html.twig', [
            'titre' => 'Création aventures',
            'form' => $form->createView(),
        ]);
    }
}