<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

/**
 * Classe AccessDeniedHandler gère le message de la réstriction
 */
class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    /**
     * Fonction handle qui affiche le message
     *
     * @param Request $request
     * @param AccessDeniedException $accessDeniedException
     * @return Response|null
     */
    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response{
        return new Response("Tu n'as pas accés à cette page. Erreur 403", 403);
    }
}