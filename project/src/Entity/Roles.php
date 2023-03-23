<?php

namespace App\Entity;

class Roles{
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_CONCEPTEUR = 'ROLE_CONCEPTEUR';
    const ROLE_USER = 'ROLE_USER';

    public function getAllRoles() : array {
        return [self::ROLE_ADMIN,self::ROLE_CONCEPTEUR,self::ROLE_USER];
    }

    public function arrayRoles() : array {
        return [self::ROLE_ADMIN => self::ROLE_ADMIN, self::ROLE_CONCEPTEUR => self::ROLE_CONCEPTEUR,self::ROLE_USER => self::ROLE_USER];
    }
}