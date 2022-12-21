<?php

namespace App\Controller;

use App\Service\AutomatedDates;
use App\Repository\DecisionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(DecisionRepository $decisionRepository, AutomatedDates $date): Response
    {
        $decisions = $decisionRepository->findBy(
            [],
            ['decisionStartTime' => 'ASC'],
            12
        );

        return $this->render(
            'home/index.html.twig',
            ['decisions' => $decisions],
        );
    }
}
