<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\Roles;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class UserController extends AbstractController{
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

    public function editUser(int $userid, EntityManagerInterface $doctrine, Request $request): Response{
        $user = $doctrine->getRepository(Utilisateur::class)->find($userid);
        $roles = new Roles();

        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class)
            ->add('email', TextType::class)
            ->add('isVerified', CheckboxType::class, [
                'required' => false,
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Role',
                'multiple' => true,
                'choices' => $roles->arrayRoles(),
                'expanded' => true,
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->flush();
            return $this->redirectToRoute('AdminMainPanel');
        }

        return $this->render('admin/userEdit.html.twig', [
            'editUser' => $form,
        ]);
    }

}
