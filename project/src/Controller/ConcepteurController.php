<?php
namespace App\Controller;

use App\Repository\AventureRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConcepteurController extends AbstractController
{
    #[Route('/concepteur/1', name: 'concepteur_frame1')]
    public function frame1(AventureRepository $aventures): Response
    {
        $aventures = $aventures->findAll();
        return $this->render('concepteur/frame1.html.twig', [
            'aventures' => $aventures
        ]);
    }

    #[Route('/concepteur/2', name: 'concepteur_frame2')]
    public function concepteurHome(): Response
    {
        return $this->render('concepteur/frame2.html.twig');
    }
}
