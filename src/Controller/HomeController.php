<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\EleveRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\StageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/dashboard', name: 'app_home')]
    public function index(
        EleveRepository $eleveRepository,
        EntrepriseRepository $entrepriseRepository,
        StageRepository $stageRepository
    ): Response
    {
        $user = $this->getUser();

        if (!$user instanceof Utilisateur) {
            throw $this->createAccessDeniedException();
        }
        
        $eleves = $eleveRepository->findAll();
        $entreprises = $entrepriseRepository->findAll();
        $stages = $stageRepository->findAll();
        
        return $this->render('home/index.html.twig', [
            'utilisateur' => $user,
            'role' => $user->getRoleUtilisateur(),
            'eleves' => $eleves,
            'entreprises' => $entreprises,
            'stages' => $stages,
        ]);
    }
}
