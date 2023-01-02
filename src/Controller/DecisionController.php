<?php

namespace App\Controller;

use App\Entity\Decision;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DecisionController extends AbstractController
{
    #[Route('decision/{decision}', methods: ['GET'], name: 'app_decision')]
    public function index(Decision $decision): Response
    {
        return $this->render('decisions/decisionPage.html.twig');
    }
}
