<?php

namespace App\Security;

use App\Entity\Doctor;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }

        // user is disabled
        if (!$user->getIsActive()) {
            throw new DisabledException('Este usuario está actualmente deshabilitado por lo que no se puede loguear.');
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
    }
}
