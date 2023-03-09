<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\Roles;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController{
    #[route('/admin', name: 'AdminMainPanel')]
    public function panel(EntityManagerInterface $doctrine): Response
    {
        $users = $doctrine->getRepository(Utilisateur::class)->getJoueurs();
        $roles = new Roles();
        return $this->render('admin/adminPanel.html.twig', [
            'all_users' => $users,
            'roles' => $roles->getAllRoles()
        ]);
    }
}