<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Classe SecurityController gère la connexion et la déconnexion
 */
class SecurityController extends AbstractController
{
    /**
     * Fonction login qui connecte un utilisateur et le redirige vers la bonne page
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */

     public function login(AuthenticationUtils $authenticationUtils): Response
    {

        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }
        $user = $this->getUser();
        if (isset($user)) {
            if (in_array('ROLE_CONCEPTEUR', $user->getRoles())) {
                return new RedirectResponse("/concepteur/accueil");   
            }
    
            if (in_array('ROLE_ADMIN', $user->getRoles())) {
                return new RedirectResponse("/admin");
            }
            return new RedirectResponse("/joueur");   
        }
     
        

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();


        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

   /**
     * Fonction logout qui déconnecte un utilisateur
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return void
     * @Route("/logout", name="app_logout")
    */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
