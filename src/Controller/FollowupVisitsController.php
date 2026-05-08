<?php

namespace App\Controller;

use App\Entity\Stage;
use App\Repository\StageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FollowupVisitsController extends AbstractController
{
    #[Route('/suivi-visites', name: 'app_suivi_visite')]
    public function index(StageRepository $stageRepository): Response
    {
        $stages = $stageRepository->findWithEleve();

        return $this->render('home/suivi_visite.html.twig', [
            'stages' => $stages,
        ]);
    }

    #[Route('/suivi-visites/{id}/commentaire', name: 'app_suivi_visite_comment', methods: ['GET', 'POST'])]
    public function comment(Request $request, Stage $stage, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            if ($this->isCsrfTokenValid('comment' . $stage->getId(), (string) $request->request->get('_token'))) {
                $commentaire = trim((string) $request->request->get('commentaire', ''));
                $stage->setCommentaire($commentaire === '' ? null : $commentaire);
                $em->flush();

                return $this->redirectToRoute('app_suivi_visite');
            }
        }

        return $this->render('home/suivi_commentaire.html.twig', [
            'stage' => $stage,
        ]);
    }
}