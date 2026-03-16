<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UsersController extends AbstractController
{
    #[Route('/utilisateurs', name: 'app_users')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        return $this->render('home/students.html.twig');
    }
}
