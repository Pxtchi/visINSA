<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\Roles;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
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

    #[route('/admin/users/roles/{userid}', name: 'manageRole', requirements: ['userid' => '\d+'], methods: ['POST'])]
    public function manageRole(int $userid, EntityManagerInterface $doctrine, Request $request): Response{
        $role_query = $request->getQueryString('role');
        $role = str_replace("role=", "",$role_query);
        $role_entity = new Roles();
        $delete = false;

        if ($role[0] == 'x'){
            $role = substr($role,1);
            $delete = true;
        }

        // Error bad role
        $role_entity_array = $role_entity->getAllRoles();
        $errrole = array_search($role, $role_entity_array);
        if (!$errrole && $role_entity_array[$errrole] != $role) {
            $params['role'] = $role;
            return $this->redirectToRoute('roleError',$params);
        }


        $user = $doctrine->getRepository(Utilisateur::class)->find($userid);
        $userRoles = $user->getroles();


        if ($delete) {
            $existingRole = array_search($role, $userRoles);
            if ($existingRole || $userRoles[$existingRole] == $role) {
                unset($userRoles[$existingRole]);
                $user->setRoles($userRoles);
                $doctrine->persist($user);
                $doctrine->flush();
                return $this->redirectToRoute('AdminMainPanel');
            }
            $params['role'] = $role;
            return $this->redirectToRoute('roleError',$params);
        }

        $userRoles[] = $role;
        $user->setRoles($userRoles);
        $doctrine->persist($user);
        $doctrine->flush();
        return $this->redirectToRoute('AdminMainPanel');
    }
    
    #[route('/admin/error', name: 'roleError', )]
    public function error(Request $request) : Response{
        $role = $request->getQueryString('role');
        $role = str_replace("role=", "",$role);

        return $this->render('admin/roleError.html.twig', [
            'role' => $role
        ]);
    }
}