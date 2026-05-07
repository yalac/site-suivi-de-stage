<?php

namespace App\Controller;

use App\Repository\StageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class HistoryController extends AbstractController
{
    #[Route('/historique', name: 'app_history')]
    public function index(StageRepository $stageRepository): Response
    {
        $finishedStages = $stageRepository->findFinished();

        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_access_denied');
        }

        return $this->render('home/history.html.twig', [
            'stages' => $finishedStages,
        ]);
    }
}

