<?php

namespace App\Controller;

use App\Entity\User;
use DateTime;
use App\Form\DecisionSearchType;
use App\Repository\DecisionRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
class DashBoardController extends AbstractController
{
    #[Route('/tbd/{user}', name: 'app_dashboard')]
    public function index(DecisionRepository $decisionRepository, User $user): Response
    {
        $user = $this->getUser();

        $myDecisions = $decisionRepository->findBy(['creator' => $user], ['decisionStartTime' => 'DESC'], 12);

        return $this->render(
            'dashboard/index.html.twig',
            [
                'myDecisions' => $myDecisions,
            ],
        );
    }
}
