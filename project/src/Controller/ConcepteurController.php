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

    #[Route('/concepteur/modif_aventure/{nomaventure}', name: 'modif_aventure')]
    public function modif_aventure(EntityManagerInterface $entityManager, string $nomaventure, AventureRepository $aventureRepository, Request $request): Response
    {
        $repository = $entityManager->getRepository(Aventure::class);
        $aventure = $repository->find($nomaventure);
        $etapes = $aventureRepository->getEtapes($nomaventure);
        return $this->render('concepteur/modif_aventure.html.twig', [
            'aventure' => $aventure,
            'titre' => 'Modifier Aventure',
            'etapes' => $etapes,
        ]);
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