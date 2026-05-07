<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Entity\Utilisateur;
use App\Form\EleveType;
use App\Form\UtilisateurType;
use App\Repository\EleveRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UsersController extends AbstractController
{
    #[Route('/utilisateurs', name: 'app_users')]
    #[Route(name: 'app_eleve_index', methods: ['GET'])]
    public function indexEleve(EleveRepository $eleveRepository, UtilisateurRepository $utilisateurRepository): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_access_denied');
        }

        return $this->render('eleve/index.html.twig', [
            'eleves' => $eleveRepository->findAll(),
            'utilisateurs' => $utilisateurRepository->findAll(),
        ]);
    }

    // CRUD pour les élèves
    // Création d'un nouvel élève
    #[Route('/newEleve', name: 'app_eleve_new', methods: ['GET', 'POST'])]
    public function newEleve(Request $request, EntityManagerInterface $entityManager): Response
    {
        $eleve = new Eleve();
        $form = $this->createForm(EleveType::class, $eleve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($eleve);
            $entityManager->flush();

            return $this->redirectToRoute('app_users', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('eleve/new.html.twig', [
            'eleve' => $eleve,
            'form' => $form,
        ]);
    }

    // Affichage des détails d'un élève
    #[Route('/Eleve/{id}', name: 'app_eleve_show', methods: ['GET'])]
    public function showEleve(Eleve $eleve): Response
    {
        return $this->render('eleve/show.html.twig', [
            'eleve' => $eleve,
        ]);
    }

    // Modification d'un élève existant
    #[Route('/Eleve/{id}/edit', name: 'app_eleve_edit', methods: ['GET', 'POST'])]
    public function editEleve(Request $request, Eleve $eleve, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EleveType::class, $eleve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_users', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('eleve/edit.html.twig', [
            'eleve' => $eleve,
            'form' => $form,
        ]);
    }


    // Suppression d'un élève
    #[Route('/Eleve/{id}', name: 'app_eleve_delete', methods: ['POST'])]
    public function deleteEleve(Request $request, Eleve $eleve, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eleve->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($eleve);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_users', [], Response::HTTP_SEE_OTHER);
    }



    // CRUD pour les utilisateurs
    // Création d'un nouvel utilisateur
    #[Route('/newUtilisateur', name: 'app_utilisateur_new', methods: ['GET', 'POST'])]
    public function newUtilisateur(Request $request, EntityManagerInterface $entityManager): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            return $this->redirectToRoute('app_users', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('utilisateur/new.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }

    // Affichage des détails d'un utilisateur
    #[Route('/Utilisateur/{id}', name: 'app_utilisateur_show', methods: ['GET'])]
    public function showUtilisateur(Utilisateur $utilisateur): Response
    {
        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

    // Modification d'un utilisateur existant
    #[Route('/Utilisateur/{id}/edit', name: 'app_utilisateur_edit', methods: ['GET', 'POST'])]
    public function editUtilisateur(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UtilisateurType::class, $utilisateur, [
            'show_password' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_users', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('utilisateur/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }

    // Suppression d'un utilisateur
    #[Route('/Utilisateur/{id}', name: 'app_utilisateur_delete', methods: ['POST'])]
    public function deleteUtilisateur(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($utilisateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_users', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/access-denied', name: 'app_access_denied')]
    public function accessDenied(): Response
    {
        return $this->render('security/access_denied.html.twig');
    }
}