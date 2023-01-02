<?php

namespace App\Controller;

use App\Repository\DecisionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserDashboardController extends AbstractController
{
    public const DECISION_LIMIT_NUMBER = 12;

    #[Route('/profil/tableau-de-bord', name: 'user_dashboard')]
    public function index(DecisionRepository $decisionRepository): Response
    {

        $decisions = $decisionRepository->findBy(
            [],
            ['decisionStartTime' => 'DESC'],
            self::DECISION_LIMIT_NUMBER
        );

        return $this->render('user_dashboard/index.html.twig', [
            'decisions' => $decisions,
        ]);
    }
}
