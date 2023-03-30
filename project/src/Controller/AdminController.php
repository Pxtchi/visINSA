<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\Roles;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController{

    public function panel(EntityManagerInterface $doctrine): Response
    {
        $users = $doctrine->getRepository(Utilisateur::class)->getJoueurs();
        $roles = new Roles();
        return $this->render('admin/adminPanel.html.twig', [
            'titre' => 'Admin Panel',
            'all_users' => $users,
            'roles' => $roles->getAllRoles()
        ]);
    }

    public function roleError(Request $request) : Response{
        $role = $request->getQueryString('role');
        $role = str_replace("role=", "",$role);

        return $this->render('admin/roleError.html.twig', [
            'role' => $role
        ]);
    }
}