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

class ConcepteurController extends AbstractController
{
    #[Route('/concepteur', name: 'concepteur')]
    public function concepteur(ManagerRegistry $doctrine): Response
    {
        $aventures = $doctrine->getRepository(Aventure::class)->findAll();
        return $this->render('concepteur/concepteur.html.twig', [
            'aventures' => $aventures
        ]);
    }

    #[Route('/concepteur/modif_aventure/{nomaventure}', name: 'modif_aventure')]
    public function modif_aventure(EntityManagerInterface $entityManager, string $nomaventure): Response
    {
        $repository = $entityManager->getRepository(Aventure::class);
        $aventure = $repository->find($nomaventure);

        $form = $this->createFormBuilder($aventure)
            ->add('nomaventure', EntityType::class, [
                'class' => Aventure::class,
            ])
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();

        return $this->render('concepteur/modif_aventure.html.twig', [
            'aventure' => $aventure,
            'form' => $form,
        ]);
    }

    #[Route('/navbar', name: 'navbar')]
    public function navbar(): Response
    {
        return $this->render('concepteur/navbar.html.twig');
    }
}
