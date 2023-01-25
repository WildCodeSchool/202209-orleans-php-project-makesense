<?php

namespace App\Controller;

use App\Entity\Decision;
use App\Entity\Interaction;
use App\Service\AutomatedDates;
use App\Form\DecisionCreationType;
use App\Repository\DecisionRepository;
use App\Repository\InteractionRepository;
use App\Service\DecisionVote;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use function PHPUnit\Framework\isEmpty;

#[IsGranted('ROLE_USER')]
class DecisionController extends AbstractController
{
    private const UP_VOTE = "upVote";
    private const DOWN_VOTE = "downVote";

    #[Route('/decision/creation', name: 'app_decision_creation')]
    public function new(
        Request $request,
        DecisionRepository $decisionRepository,
        AutomatedDates $automatedDates,
        Security $security
    ): Response {
        $decision = new Decision();

        $form = $this->createForm(DecisionCreationType::class, $decision);
        /** @var \App\Entity\User */
        $user = $this->getUser();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $decision->setCreator($user);

            $decision->setFirstDecisionEndDate(
                $automatedDates->firstDecisionEndDateCalculation($decision)
            );
            $decision->setConflictEndDate(
                $automatedDates->conflictEndDateCalculation($decision)
            );
            $decision->setFinalDecisionEndDate(
                $automatedDates->finalDecisionEndDateCalculation($decision)
            );
            $decisionRepository->save($decision, true);

            return $this->redirectToRoute('app_home');
        }

        return $this->renderForm('decision_creation/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('decision/{decision}', methods: ['GET', 'POST'], name: 'app_decision')]
    public function index(
        Decision $decision,
        InteractionRepository $interactionRepo,
        Request $request,
        DecisionVote $decisionVote
    ): Response {
        /** @var \App\Entity\User */
        $user = $this->getUser();

        $interaction = $interactionRepo->findOneBy([
            'decision' => $decision,
            'user' => $user,
        ]);

        if ($this->isCsrfTokenValid('vote' . $user->getId(), $request->request->get('_token'))) {
            if (
                $request->get(self::DOWN_VOTE) === '' && $interaction->isVote() === false
                || $request->get(self::UP_VOTE) === '' && $interaction->isVote() === true
            ) {
                $interaction->setVote(null);
            } elseif ($request->get(self::DOWN_VOTE) === '') {
                $interaction->setVote(false);
            } elseif ($request->get(self::UP_VOTE) === '') {
                $interaction->setVote(true);
            }

            $interactionRepo->save($interaction, true);

            return $this->redirectToRoute('app_decision', ['decision' => $decision->getId()]);
        }

        return $this->render('decisions/decisionView.html.twig', [
            'decision' => $decision,
            'upVotes' => $decisionVote->countUpVotes($decision),
            'downVotes' => $decisionVote->countDownVotes($decision)
        ]);
    }
}
