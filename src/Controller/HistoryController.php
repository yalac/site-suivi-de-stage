<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HistoryController extends AbstractController
{
    #[Route('/historique', name: 'app_history')]
    public function index(): Response
    {
        return $this->render('home/history.html.twig');
    }
}
