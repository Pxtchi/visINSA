<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Entity\Utilisateur;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EquipeController extends AbstractController{

    public function addEquipe(EntityManagerInterface $doctrine, Request $request): Response{
        $equipe = new Equipe();
        return $this->editEquipe($equipe,$doctrine,$request);

    }

    public function editExistentEquipe(int $equipeid, EntityManagerInterface $doctrine, Request $request): Response
    {
        $equipe = $doctrine->getRepository(Equipe::class)->find($equipeid);
        return $this->editEquipe($equipe ,$doctrine,$request);
    }
    public function editEquipe(Equipe $equipe, EntityManagerInterface $doctrine, Request $request): Response{

        $users = $doctrine->getRepository(Utilisateur::class)->getJoueurs();
        $userTab = [];
        foreach ($users as $user){
            $userTab[$user->getUserIdentifier()] = $user;
        }
        $form = $this->createFormBuilder($equipe)
            ->add('nomEquipe', TextType::class)
            ->add('joueur', ChoiceType::class, [
                'mapped' => false,
                'multiple' => false,
                'choices' => $userTab,
            ])
            ->add('nomJoueurs',TextType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $equipe->setIdJoueur($form->get('joueur')->getData()->getId());
            $doctrine->persist($equipe);
            $doctrine->flush();
            return $this->redirectToRoute('AdminMainPanel');
        }

        return $this->render('admin/equipeEdit.html.twig', [
            'titre' => "Edit: " . $equipe->getNomequipe(),
            'editEquipe' => $form,
        ]);
    }

}
