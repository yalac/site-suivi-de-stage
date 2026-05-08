<?php

namespace App\Controller;

use App\Repository\EleveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FollowupVisitsController extends AbstractController
{
    #[Route('/suivi-visites', name: 'app_suivi_visite')]
    public function index(EleveRepository $eleveRepository): Response
    {
        $eleves = $eleveRepository->findAll();

        return $this->render('home/suivi_visite.html.twig', [
            'eleves' => $eleves,
        ]);
    }
}