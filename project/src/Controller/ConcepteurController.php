<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Aventure;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SearchType;
use App\Services\QrcodeService;

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
    public function modif_aventure(EntityManagerInterface $entityManager, string $nomaventure): Response
    {
        $repository = $entityManager->getRepository(Aventure::class);
        $aventure = $repository->find($nomaventure);

        return $this->render('concepteur/modif_aventure.html.twig', [
            'aventure' => $aventure,
        ]);
    }

    public function modif_question(EntityManagerInterface $entityManager, string $nomaventure): Response
    {
        $repository = $entityManager->getRepository(Aventure::class);
        $aventure = $repository->find($nomaventure);

        $form = $this->createFormBuilder($aventure)
            ->add('nomaventure', EntityType::class, [
                'class' => Aventure::class,
            ])
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();

        return $this->render('concepteur/modif_question.html.twig', [
            'aventure' => $aventure,
            'form' => $form,
        ]);
    }

    public function modif_etape(EntityManagerInterface $entityManager, string $nomaventure): Response
    {
        $repository = $entityManager->getRepository(Aventure::class);
        $aventure = $repository->find($nomaventure);

        $form = $this->createFormBuilder($aventure)
            ->add('nomaventure', EntityType::class, [
                'class' => Aventure::class,
            ])
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();

        return $this->render('concepteur/modif_etape.html.twig', [
            'aventure' => $aventure,
            'form' => $form,
        ]);
    }

    #[Route('/qrcodegenerator', name: 'qrcodegenerator')]
    /**
     * @param Request $request
     * @param QrcodeService $qrcodeService
     * @return Response
     */
    public function qrcodegenerator(Request $request, QrcodeService $qrcodeService): Response
    {
        #composer require endroid/qr-code
        #composer require endroid/qr-code-bundle
        #enable php-gd
        $qrCode = null;
        $form = $this->createForm(SearchType::class, null);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $qrCode = $qrcodeService->qrcode($data['name']);
        }

        return $this->render('concepteur/default/index.html.twig', [
            'form' => $form->createView(),
            'qrCode' => $qrCode
        ]);
    }
}