<?php

namespace App\Controller;

use App\Repository\DecisionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(DecisionRepository $decisionRepository): Response
    {
        $allDecisions = $decisionRepository->findBy(
            [],
            ['decisionStartTime' => 'ASC'],
            12
        );

        return $this->render(
            'home/index.html.twig',
            ['allDecisions' => $allDecisions]
        );
    }
}
