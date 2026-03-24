<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Stage;
use App\Form\StageType;
use App\Repository\StageRepository;

class InternshipsController extends AbstractController
{
	#[Route('/stages', name: 'app_internships')]
	public function index(StageRepository $stageRepository): Response
	{
		$stages = $stageRepository->findCurrent();
		$allStages = $stageRepository->findAll();

		return $this->render('home/internships.html.twig', [
			'stages' => $stages,
			'allStages' => $allStages,
		]);
	}

	#[Route('/stages/new', name: 'app_stage_new', methods: ['GET','POST'])]
	public function new(Request $request, EntityManagerInterface $em): Response
	{
		$stage = new Stage();
		$form = $this->createForm(StageType::class, $stage);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em->persist($stage);
			$em->flush();

			return $this->redirectToRoute('app_internships');
		}

		return $this->render('home/internships_new.html.twig', [
			'form' => $form->createView(),
		]);
	}

	#[Route('/stages/{id}', name: 'app_stage_show', methods: ['GET'])]
	public function show(Stage $stage): Response
	{
		return $this->render('home/internships_show.html.twig', [
			'stage' => $stage,
		]);
	}

	#[Route('/stages/{id}/edit', name: 'app_stage_edit', methods: ['GET','POST'])]
	public function edit(Request $request, Stage $stage, EntityManagerInterface $em): Response
	{
		$form = $this->createForm(StageType::class, $stage);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em->flush();

			return $this->redirectToRoute('app_internships');
		}

		return $this->render('home/internships_edit.html.twig', [
			'form' => $form->createView(),
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

		return $this->redirectToRoute('app_internships');
	}
}

