<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class InternshipsController extends AbstractController
{
    #[Route('/stages', name: 'app_internships')]
    public function index(): Response
    {
        return $this->render('home/internships.html.twig');
    }
}
