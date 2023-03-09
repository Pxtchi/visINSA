<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController{
    #[route('/admin', name: 'AdminMainPanel')]
    public function panel(EntityManagerInterface $doctrine): Response
    {
        $users = $doctrine->getRepository(Utilisateur::class)->getJoueurs();
        return $this->render('admin/adminPanel.html.twig', [
            'all_users' => $users
        ]);
    }
}