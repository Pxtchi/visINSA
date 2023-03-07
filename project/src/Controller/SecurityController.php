<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    #[Route('/', name: 'connection')]
    public function number(): Response
    {
        return $this->render('security/securityHome.html.twig');

    }
}
