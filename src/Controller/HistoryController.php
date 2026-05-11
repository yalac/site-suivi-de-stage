<?php

namespace App\Controller;

use App\Controller\Traits\AdminAccessTrait;
use App\Entity\Historique;
use App\Repository\HistoriqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class HistoryController extends AbstractController
{
    use AdminAccessTrait;

    #[Route('/historique', name: 'app_history')]
    public function index(
        HistoriqueRepository $historiqueRepository,
    ): Response
    {
        if ($response = $this->redirectIfNotAdmin()) {
            return $response;
        }

        $historiques = $historiqueRepository->findAll();
        $normalized = array_map(fn (Historique $historique) => $this->normalizeHistory($historique), $historiques);

        usort($normalized, static function (array $a, array $b): int {
            return $b['dateModification'] <=> $a['dateModification'];
        });

        return $this->render('home/history.html.twig', [
            'historiques' => $normalized,
        ]);
    }

    #[Route('/historique/{id}/supprimer', name: 'app_history_delete', methods: ['POST'])]
    public function delete(int $id, Request $request, EntityManagerInterface $entityManager): RedirectResponse
    {
        if ($response = $this->redirectIfNotAdmin()) {
            return $response;
        }

        if (!$this->isCsrfTokenValid('delete_history_'.$id, $request->request->get('_token'))) {
            return $this->redirectToRoute('app_history');
        }

        $historique = $entityManager->getRepository(Historique::class)->find($id);

        if ($historique !== null) {
            $entityManager->remove($historique);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_history');
    }

    #[Route('/historique/tout-supprimer', name: 'app_history_clear', methods: ['POST'])]
    public function clear(Request $request, EntityManagerInterface $entityManager): RedirectResponse
    {
        if ($response = $this->redirectIfNotAdmin()) {
            return $response;
        }

        if (!$this->isCsrfTokenValid('clear_history', $request->request->get('_token'))) {
            return $this->redirectToRoute('app_history');
        }

        $entityManager->createQuery(sprintf('DELETE FROM %s h', Historique::class))->execute();

        return $this->redirectToRoute('app_history');
    }

    private function normalizeHistory(Historique $historique): array
    {
        $entityType = $historique->getTypeEntite();
        
        $targetLabel = match ($entityType) {
            'stage' => $historique->getStage() && $historique->getStage()->getEleveStage() && $historique->getStage()->getEntrepriseStage()
                ? $historique->getStage()->getEleveStage()->getPrenomEleve().' '.$historique->getStage()->getEleveStage()->getNomEleve().' - '.$historique->getStage()->getEntrepriseStage()->getNomEntreprise()
                : ($historique->getStage() ? 'Stage supprimé' : 'N/A'),
            'eleve' => $historique->getEleve()
                ? $historique->getEleve()->getPrenomEleve().' '.$historique->getEleve()->getNomEleve()
                : 'Élève supprimé',
            'utilisateur' => null,
            'entreprise' => $historique->getEntreprise()
                ? $historique->getEntreprise()->getNomEntreprise()
                : 'Entreprise supprimée',
            default => null,
        };
        
        $entityTypeDisplay = match ($entityType) {
            'stage' => 'Stage',
            'eleve' => 'Eleve',
            'utilisateur' => 'Utilisateur',
            'entreprise' => 'Entreprise',
            default => 'Inconnu',
        };

        return $this->buildHistoryRow(
            $historique->getId(),
            $entityType,
            $entityTypeDisplay,
            $historique->getDateModification(),
            $historique->getTypeAction(),
            $historique->getUtilisateur()
                ? $historique->getUtilisateur()->getPrenomUtilisateur().' '.$historique->getUtilisateur()->getNomUtilisateur()
                : 'Système',
            $targetLabel,
            $historique->getChampModifie(),
            $historique->getAncienneValeur(),
            $historique->getNouvelleValeur(),
        );
    }

    private function buildHistoryRow(
        int $id,
        string $historyType,
        string $entityType,
        ?\DateTimeImmutable $dateModification,
        ?string $typeAction,
        string $actorLabel,
        ?string $targetLabel,
        ?string $champModifie,
        ?string $ancienneValeur,
        ?string $nouvelleValeur,
    ): array {
        return [
            'id' => $id,
            'historyType' => $historyType,
            'dateModification' => $dateModification,
            'typeAction' => $typeAction,
            'entityType' => $entityType,
            'actorLabel' => $actorLabel,
            'targetLabel' => $targetLabel,
            'champModifie' => $champModifie,
            'ancienneValeur' => $ancienneValeur,
            'nouvelleValeur' => $nouvelleValeur,
        ];
    }
}

