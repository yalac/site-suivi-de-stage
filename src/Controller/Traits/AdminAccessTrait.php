<?php

namespace App\Controller\Traits;

use Symfony\Component\HttpFoundation\RedirectResponse;

trait AdminAccessTrait
{
    private function redirectIfNotAdmin(): ?RedirectResponse
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_access_denied');
        }

        return null;
    }
}