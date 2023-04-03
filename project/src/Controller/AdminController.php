<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Entity\Utilisateur;
use App\Entity\Roles;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController{

    public function panel(EntityManagerInterface $doctrine): Response
    {
        $userRepository = $doctrine->getRepository(Utilisateur::class);
        $users = $userRepository->getJoueurs();
        $roles = new Roles();
        $equip = $doctrine->getRepository(Equipe::class)->findAll();

        $equipjoueur = [];
        foreach ($equip as $ekip){
            $player = $userRepository->find($ekip->getIdJoueur());
            if ($player) {
                $equipjoueur[$ekip->getIdJoueur()] = $player->getUserIdentifier();
            }else {
                $equipjoueur[$ekip->getIdJoueur()] = "Joueur Indéfini";
            }
        }
        return $this->render('admin/adminPanel.html.twig', [
            'titre' => 'Admin Panel',
            'all_users' => $users,
            'roles' => $roles->getAllRoles(),
            'equipes' => $equip,
            'equipJoueur' => $equipjoueur,
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