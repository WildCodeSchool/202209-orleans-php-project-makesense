<?php

namespace App\Controller;

use App\Repository\DecisionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilUserController extends AbstractController
{
    public const DECISION_LIMIT_NUMBER = 12;

    #[Route('/profil/user', name: 'app_profil_user')]
    public function index(DecisionRepository $decisionRepository): Response
    {

        $decisions = $decisionRepository->findBy(
            [],
            ['decisionStartTime' => 'ASC'],
            self::DECISION_LIMIT_NUMBER
        );

        return $this->render('profil_user/index.html.twig', [
            'decisions' => $decisions,
        ]);
    }
}
