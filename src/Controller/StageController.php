<?php

namespace App\Controller;

use App\Controller\Traits\AdminAccessTrait;
use App\Repository\EleveRepository;
use App\Entity\Stage;
use App\Form\StageType;
use App\Repository\StageRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StageController extends AbstractController
{
    use AdminAccessTrait;

	#[Route('/stages', name: 'app_stage')]
	public function index(StageRepository $stageRepository): Response
	{
		if ($response = $this->redirectIfNotAdmin()) {
			return $response;
		}

		$stages = $stageRepository->findAllOrdered();

		return $this->render('home/stage.html.twig', [
			'stages' => $stages,
		]);
	}

	#[Route('/stages/new', name: 'app_stage_new', methods: ['GET','POST'])]
	public function new(Request $request, EntityManagerInterface $em, UtilisateurRepository $utilisateurRepository, EleveRepository $eleveRepository): Response
	{
		$stage = new Stage();
		$form = $this->createStageForm($stage, $utilisateurRepository, $eleveRepository);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em->persist($stage);
			$em->flush();

			return $this->redirectToStageIndex();
		}

		return $this->render('stage/new.html.twig', [
			'form' => $form,
		]);
	}

	#[Route('/stages/{id}', name: 'app_stage_show', methods: ['GET'])]
	public function show(Stage $stage): Response
	{
		return $this->render('stage/show.html.twig', [
			'stage' => $stage,
		]);
	}

	#[Route('/stages/{id}/edit', name: 'app_stage_edit', methods: ['GET','POST'])]
	public function edit(Request $request, Stage $stage, EntityManagerInterface $em, UtilisateurRepository $utilisateurRepository, EleveRepository $eleveRepository): Response
	{
		$form = $this->createStageForm($stage, $utilisateurRepository, $eleveRepository);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em->flush();

			return $this->redirectToStageIndex();
		}

		return $this->render('stage/edit.html.twig', [
			'form' => $form,
			'stage' => $stage,
		]);
	}

	#[Route('/stages/{id}', name: 'app_stage_delete', methods: ['POST'])]
	public function delete(Request $request, Stage $stage, EntityManagerInterface $em): Response
	{
		if ($this->isCsrfTokenValid('delete'.$stage->getId(), $request->request->get('_token'))) {
			$em->remove($stage);
			$em->flush();
		}

		return $this->redirectToStageIndex();
	}

	private function createStageForm(Stage $stage, UtilisateurRepository $utilisateurRepository, EleveRepository $eleveRepository)
	{
		return $this->createForm(StageType::class, $stage, [
			'prof_choices' => $utilisateurRepository->findProfFullNames(),
			'eleve_query_builder' => $eleveRepository->createAvailableForStageQueryBuilder($stage->getEleveStage()),
		]);
	}

	private function redirectToStageIndex(): Response
	{
		return $this->redirectToRoute('app_stage');
	}
}

