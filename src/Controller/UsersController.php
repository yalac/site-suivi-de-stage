<?php

namespace App\Controller;

use App\Controller\Traits\AdminAccessTrait;
use App\Entity\Eleve;
use App\Entity\Utilisateur;
use App\Form\EleveType;
use App\Form\UtilisateurType;
use App\Repository\EleveRepository;
use App\Repository\StageRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UsersController extends AbstractController
{
    use AdminAccessTrait;

    #[Route('/utilisateurs', name: 'app_users')]
    #[Route(name: 'app_eleve_index', methods: ['GET'])]
    public function indexEleve(EleveRepository $eleveRepository, UtilisateurRepository $utilisateurRepository): Response
    {
        if ($response = $this->redirectIfNotAdmin()) {
            return $response;
        }

        return $this->render('home/utilisateur.html.twig', [
            'eleves' => $eleveRepository->findAll(),
            'utilisateurs' => $utilisateurRepository->findAll(),
        ]);
    }

    #[Route('/newEleve', name: 'app_eleve_new', methods: ['GET', 'POST'])]
    public function newEleve(Request $request, EntityManagerInterface $entityManager): Response
    {
        $eleve = new Eleve();
        $form = $this->createEleveForm($eleve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($eleve);
            $entityManager->flush();

            return $this->redirectToUsersIndex();
        }

        return $this->render('eleve/new.html.twig', [
            'eleve' => $eleve,
            'form' => $form,
        ]);
    }

    #[Route('/Eleve/{id}', name: 'app_eleve_show', methods: ['GET'])]
    public function showEleve(Eleve $eleve): Response
    {
        return $this->render('eleve/show.html.twig', [
            'eleve' => $eleve,
        ]);
    }

    #[Route('/Eleve/{id}/edit', name: 'app_eleve_edit', methods: ['GET', 'POST'])]
    public function editEleve(Request $request, Eleve $eleve, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createEleveForm($eleve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToUsersIndex();
        }

        return $this->render('eleve/edit.html.twig', [
            'eleve' => $eleve,
            'form' => $form,
        ]);
    }

    #[Route('/Eleve/{id}', name: 'app_eleve_delete', methods: ['POST'])]
    public function deleteEleve(Request $request, Eleve $eleve, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eleve->getId(), $request->getPayload()->getString('_token'))) {
            if ($eleve->getStageEleve() !== null) {
                $this->addFlash('warning', 'Impossible de supprimer cet élève : un stage correspond déjà à cet élève.');

                return $this->redirectToUsersIndex();
            }

            try {
                $entityManager->remove($eleve);
                $entityManager->flush();
            } catch (ForeignKeyConstraintViolationException) {
                $this->addFlash('warning', 'Impossible de supprimer cet élève : un stage correspond déjà à cet élève.');
            }
        }

        return $this->redirectToUsersIndex();
    }

    #[Route('/newUtilisateur', name: 'app_utilisateur_new', methods: ['GET', 'POST'])]
    public function newUtilisateur(Request $request, EntityManagerInterface $entityManager): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createUtilisateurForm($utilisateur, true);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            return $this->redirectToUsersIndex();
        }

        return $this->render('utilisateur/new.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }

    #[Route('/Utilisateur/{id}', name: 'app_utilisateur_show', methods: ['GET'])]
    public function showUtilisateur(Utilisateur $utilisateur): Response
    {
        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

    #[Route('/Utilisateur/{id}/edit', name: 'app_utilisateur_edit', methods: ['GET', 'POST'])]
    public function editUtilisateur(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createUtilisateurForm($utilisateur, false);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToUsersIndex();
        }

        return $this->render('utilisateur/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }

    #[Route('/Utilisateur/{id}', name: 'app_utilisateur_delete', methods: ['POST'])]
    public function deleteUtilisateur(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($utilisateur);
            $entityManager->flush();
        }

        return $this->redirectToUsersIndex();
    }

    #[Route('/access-denied', name: 'app_access_denied')]
    public function accessDenied(): Response
    {
        return $this->render('security/access_denied.html.twig');
    }

    private function redirectToUsersIndex(): Response
    {
        return $this->redirectToRoute('app_users', [], Response::HTTP_SEE_OTHER);
    }

    private function createEleveForm(Eleve $eleve)
    {
        return $this->createForm(EleveType::class, $eleve);
    }

    private function createUtilisateurForm(Utilisateur $utilisateur, bool $showPassword)
    {
        return $this->createForm(UtilisateurType::class, $utilisateur, [
            'show_password' => $showPassword,
        ]);
    }
}