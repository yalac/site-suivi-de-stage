<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class HistoryController extends AbstractController
{
    #[Route('/historique', name: 'app_history')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        return $this->render('home/history.html.twig');
    }
}
