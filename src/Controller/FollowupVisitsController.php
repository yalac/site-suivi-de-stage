<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FollowupVisitsController extends AbstractController
{
    #[Route('/suivi-visites', name: 'app_followup_visits')]
    public function index(): Response
    {
        return $this->render('home/followup_visits.html.twig');
    }
}
