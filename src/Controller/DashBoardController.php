<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Interaction;
use App\Service\StatusUpdater;
use App\Repository\DecisionRepository;
use App\Repository\InteractionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_MEMBER')]
class DashBoardController extends AbstractController
{
    public const DECISION_LIMIT = 4;

    public function __construct(private StatusUpdater $statusUpdater)
    {
    }


    #[Route('/tableau-de-bord/{user}', name: 'app_dashboard')]
    public function index(
        DecisionRepository $decisionRepository,
        User $user,
        InteractionRepository $interactionRepo
    ): Response {
        $this->denyAccessUnlessGranted('view', $user);

        $myDecisions = $decisionRepository->findBy(
            ['creator' => $user],
            ['decisionStartTime' => 'DESC'],
            self::DECISION_LIMIT
        );

        $impactedInteractions = $interactionRepo->findBy(
            [
                'user' => $user,
                'decisionRole' => Interaction::DECISION_IMPACTED
            ],
            ['decision' => 'DESC'],
            self::DECISION_LIMIT,
        );


        $expertInteractions = $interactionRepo->findBy(
            [
                'user' => $user,
                'decisionRole' => Interaction::DECISION_EXPERT
            ],
            ['decision' => 'DESC'],
            self::DECISION_LIMIT,
        );

        $interactions = array_merge($expertInteractions, $impactedInteractions);

        $decisions = [];
        foreach ($interactions as $interaction) {
            $decisions[] = $interaction->getDecision();
        }

        $decisions = array_merge($myDecisions, $decisions);

        $this->statusUpdater->saveDecisionsStatus($decisions);

        return $this->render(
            'dashboard/index.html.twig',
            [
                'myDecisions' => $myDecisions,
                'impactedInteractions' => $impactedInteractions,
                'expertInteractions' => $expertInteractions
            ],
        );
    }
}
