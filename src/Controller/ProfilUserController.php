<?php

namespace App\Controller;

use App\Repository\DecisionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilUserController extends AbstractController
{
    #[Route('/profil/user', name: 'app_profil_user')]
    public function index(DecisionRepository $decisionRepository): Response
    {

        $decisions = $decisionRepository->findBy(
            [],
            ['decisionStartTime' => 'ASC'],
            12
        );

        return $this->render('profil_user/index.html.twig', [
            'controller_name' => 'ProfilUserController',
            'decisions' => $decisions,
        ]);
    }
}
