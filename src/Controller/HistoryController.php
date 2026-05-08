<?php

namespace App\Controller;

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
    #[Route('/historique', name: 'app_history')]
    public function index(
        HistoriqueStageRepository $historiqueStageRepository,
        HistoriqueUtilisateurRepository $historiqueUtilisateurRepository,
        HistoriqueEntrepriseRepository $historiqueEntrepriseRepository,
        HistoriqueEleveRepository $historiqueEleveRepository,
    ): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_access_denied');
        }

        $historiques = array_merge(
            array_map(fn (HistoriqueStage $historique) => $this->normalizeStageHistory($historique), $historiqueStageRepository->findAll()),
            array_map(fn (HistoriqueEleve $historique) => $this->normalizeEleveHistory($historique), $historiqueEleveRepository->findAll()),
            array_map(fn (HistoriqueUtilisateur $historique) => $this->normalizeUtilisateurHistory($historique), $historiqueUtilisateurRepository->findAll()),
            array_map(fn (HistoriqueEntreprise $historique) => $this->normalizeEntrepriseHistory($historique), $historiqueEntrepriseRepository->findAll()),
        );

        // Trier par date décroissante
        usort($historiques, function ($a, $b) {
            return $b['dateModification'] <=> $a['dateModification'];
        });

        return $this->render('home/history.html.twig', [
            'historiques' => $historiques,
        ]);
    }

    #[Route('/historique/{type}/{id}/supprimer', name: 'app_history_delete', methods: ['POST'])]
    public function delete(string $type, int $id, Request $request, EntityManagerInterface $entityManager): RedirectResponse
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_access_denied');
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
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_access_denied');
        }

        if (!$this->isCsrfTokenValid('clear_history', $request->request->get('_token'))) {
            return $this->redirectToRoute('app_history');
        }

        $entityManager->createQuery('DELETE FROM App\\Entity\\HistoriqueStage h')->execute();
        $entityManager->createQuery('DELETE FROM App\\Entity\\HistoriqueEleve h')->execute();
        $entityManager->createQuery('DELETE FROM App\\Entity\\HistoriqueUtilisateur h')->execute();
        $entityManager->createQuery('DELETE FROM App\\Entity\\HistoriqueEntreprise h')->execute();

        return $this->redirectToRoute('app_history');
    }

    private function normalizeStageHistory(HistoriqueStage $historique): array
    {
        return [
            'id' => $historique->getId(),
            'historyType' => 'stage',
            'dateModification' => $historique->getDateModification(),
            'typeAction' => $historique->getTypeAction(),
            'entityType' => 'Stage',
            'actorLabel' => $historique->getUtilisateur()
                ? $historique->getUtilisateur()->getPrenomUtilisateur().' '.$historique->getUtilisateur()->getNomUtilisateur()
                : 'Système',
            'targetLabel' => $historique->getStage() && $historique->getStage()->getEleveStage() && $historique->getStage()->getEntrepriseStage()
                ? $historique->getStage()->getEleveStage()->getPrenomEleve().' '.$historique->getStage()->getEleveStage()->getNomEleve().' - '.$historique->getStage()->getEntrepriseStage()->getNomEntreprise()
                : ($historique->getStage() ? 'Stage supprimé' : 'N/A'),
            'champModifie' => $historique->getChampModifie(),
            'ancienneValeur' => $historique->getAncienneValeur(),
            'nouvelleValeur' => $historique->getNouvelleValeur(),
        ];
    }

    private function normalizeEleveHistory(HistoriqueEleve $historique): array
    {
        return [
            'id' => $historique->getId(),
            'historyType' => 'eleve',
            'dateModification' => $historique->getDateModification(),
            'typeAction' => $historique->getTypeAction(),
            'entityType' => 'Eleve',
            'actorLabel' => $historique->getUtilisateur()
                ? $historique->getUtilisateur()->getPrenomUtilisateur().' '.$historique->getUtilisateur()->getNomUtilisateur()
                : 'Système',
            'targetLabel' => $historique->getEleve()
                ? $historique->getEleve()->getPrenomEleve().' '.$historique->getEleve()->getNomEleve()
                : 'Élève supprimé',
            'champModifie' => $historique->getChampModifie(),
            'ancienneValeur' => $historique->getAncienneValeur(),
            'nouvelleValeur' => $historique->getNouvelleValeur(),
        ];
    }

    private function normalizeUtilisateurHistory(HistoriqueUtilisateur $historique): array
    {
        return [
            'id' => $historique->getId(),
            'historyType' => 'utilisateur',
            'dateModification' => $historique->getDateModification(),
            'typeAction' => $historique->getTypeAction(),
            'entityType' => 'Utilisateur',
            'actorLabel' => $historique->getAuteur()
                ? $historique->getAuteur()->getPrenomUtilisateur().' '.$historique->getAuteur()->getNomUtilisateur()
                : 'Système',
            'targetLabel' => $historique->getUtilisateur()
                ? $historique->getUtilisateur()->getPrenomUtilisateur().' '.$historique->getUtilisateur()->getNomUtilisateur()
                : 'Utilisateur supprimé',
            'champModifie' => $historique->getChampModifie(),
            'ancienneValeur' => $historique->getAncienneValeur(),
            'nouvelleValeur' => $historique->getNouvelleValeur(),
        ];
    }

    private function normalizeEntrepriseHistory(HistoriqueEntreprise $historique): array
    {
        return [
            'id' => $historique->getId(),
            'historyType' => 'entreprise',
            'dateModification' => $historique->getDateModification(),
            'typeAction' => $historique->getTypeAction(),
            'entityType' => 'Entreprise',
            'actorLabel' => $historique->getUtilisateur()
                ? $historique->getUtilisateur()->getPrenomUtilisateur().' '.$historique->getUtilisateur()->getNomUtilisateur()
                : 'Système',
            'targetLabel' => $historique->getEntreprise()
                ? $historique->getEntreprise()->getNomEntreprise()
                : 'Entreprise supprimée',
            'champModifie' => $historique->getChampModifie(),
            'ancienneValeur' => $historique->getAncienneValeur(),
            'nouvelleValeur' => $historique->getNouvelleValeur(),
        ];
    }
}

