<?php

namespace App\Controller;

use App\Controller\Traits\AdminAccessTrait;
use App\Entity\HistoriqueEntreprise;
use App\Entity\HistoriqueEleve;
use App\Entity\HistoriqueStage;
use App\Entity\HistoriqueUtilisateur;
use App\Repository\HistoriqueStageRepository;
use App\Repository\HistoriqueEleveRepository;
use App\Repository\HistoriqueUtilisateurRepository;
use App\Repository\HistoriqueEntrepriseRepository;
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
        HistoriqueStageRepository $historiqueStageRepository,
        HistoriqueUtilisateurRepository $historiqueUtilisateurRepository,
        HistoriqueEntrepriseRepository $historiqueEntrepriseRepository,
        HistoriqueEleveRepository $historiqueEleveRepository,
    ): Response
    {
        if ($response = $this->redirectIfNotAdmin()) {
            return $response;
        }

        $historiques = array_merge(
            array_map(fn (HistoriqueStage $historique) => $this->normalizeStageHistory($historique), $historiqueStageRepository->findAll()),
            array_map(fn (HistoriqueEleve $historique) => $this->normalizeEleveHistory($historique), $historiqueEleveRepository->findAll()),
            array_map(fn (HistoriqueUtilisateur $historique) => $this->normalizeUtilisateurHistory($historique), $historiqueUtilisateurRepository->findAll()),
            array_map(fn (HistoriqueEntreprise $historique) => $this->normalizeEntrepriseHistory($historique), $historiqueEntrepriseRepository->findAll()),
        );

        usort($historiques, static function (array $a, array $b): int {
            return $b['dateModification'] <=> $a['dateModification'];
        });

        return $this->render('home/history.html.twig', [
            'historiques' => $historiques,
        ]);
    }

    #[Route('/historique/{type}/{id}/supprimer', name: 'app_history_delete', methods: ['POST'])]
    public function delete(string $type, int $id, Request $request, EntityManagerInterface $entityManager): RedirectResponse
    {
        if ($response = $this->redirectIfNotAdmin()) {
            return $response;
        }

        if (!$this->isCsrfTokenValid('delete_history_'.$type.'_'.$id, $request->request->get('_token'))) {
            return $this->redirectToRoute('app_history');
        }

        $repository = match ($type) {
            'stage' => $entityManager->getRepository(HistoriqueStage::class),
            'eleve' => $entityManager->getRepository(HistoriqueEleve::class),
            'utilisateur' => $entityManager->getRepository(HistoriqueUtilisateur::class),
            'entreprise' => $entityManager->getRepository(HistoriqueEntreprise::class),
            default => null,
        };

        if ($repository !== null) {
            $historique = $repository->find($id);

            if ($historique !== null) {
                $entityManager->remove($historique);
                $entityManager->flush();
            }
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

        foreach ([
            HistoriqueStage::class,
            HistoriqueEleve::class,
            HistoriqueUtilisateur::class,
            HistoriqueEntreprise::class,
        ] as $historyClass) {
            $entityManager->createQuery(sprintf('DELETE FROM %s h', $historyClass))->execute();
        }

        return $this->redirectToRoute('app_history');
    }

    private function normalizeStageHistory(HistoriqueStage $historique): array
    {
        $targetLabel = $historique->getStage() && $historique->getStage()->getEleveStage() && $historique->getStage()->getEntrepriseStage()
            ? $historique->getStage()->getEleveStage()->getPrenomEleve().' '.$historique->getStage()->getEleveStage()->getNomEleve().' - '.$historique->getStage()->getEntrepriseStage()->getNomEntreprise()
            : ($historique->getStage() ? 'Stage supprimé' : 'N/A');

        return $this->buildHistoryRow(
            $historique->getId(),
            'stage',
            'Stage',
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

    private function normalizeEleveHistory(HistoriqueEleve $historique): array
    {
        return $this->buildHistoryRow(
            $historique->getId(),
            'eleve',
            'Eleve',
            $historique->getDateModification(),
            $historique->getTypeAction(),
            $historique->getUtilisateur()
                ? $historique->getUtilisateur()->getPrenomUtilisateur().' '.$historique->getUtilisateur()->getNomUtilisateur()
                : 'Système',
            $historique->getEleve()
                ? $historique->getEleve()->getPrenomEleve().' '.$historique->getEleve()->getNomEleve()
                : 'Élève supprimé',
            $historique->getChampModifie(),
            $historique->getAncienneValeur(),
            $historique->getNouvelleValeur(),
        );
    }

    private function normalizeUtilisateurHistory(HistoriqueUtilisateur $historique): array
    {
        return $this->buildHistoryRow(
            $historique->getId(),
            'utilisateur',
            'Utilisateur',
            $historique->getDateModification(),
            $historique->getTypeAction(),
            $historique->getUtilisateur()
                ? $historique->getUtilisateur()->getPrenomUtilisateur().' '.$historique->getUtilisateur()->getNomUtilisateur()
                : 'Système',
            null,
            $historique->getChampModifie(),
            $historique->getAncienneValeur(),
            $historique->getNouvelleValeur(),
        );
    }

    private function normalizeEntrepriseHistory(HistoriqueEntreprise $historique): array
    {
        return $this->buildHistoryRow(
            $historique->getId(),
            'entreprise',
            'Entreprise',
            $historique->getDateModification(),
            $historique->getTypeAction(),
            $historique->getUtilisateur()
                ? $historique->getUtilisateur()->getPrenomUtilisateur().' '.$historique->getUtilisateur()->getNomUtilisateur()
                : 'Système',
            $historique->getEntreprise()
                ? $historique->getEntreprise()->getNomEntreprise()
                : 'Entreprise supprimée',
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

