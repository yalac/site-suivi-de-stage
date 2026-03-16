<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CompaniesController extends AbstractController
{
    #[Route('/entreprises', name: 'app_companies')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        return $this->render('home/companies.html.twig');
    }
}
