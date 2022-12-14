<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DecisionController extends AbstractController
{
    #[Route('decision', name: 'app_decision')]
    public function index(): Response
    {
        return $this->render('decisions/decisionPage.html.twig');
    }
}
