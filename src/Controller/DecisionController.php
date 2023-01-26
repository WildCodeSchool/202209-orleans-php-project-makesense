<?php

namespace App\Controller;

use App\Service\Voting;
use App\Entity\Decision;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Entity\Interaction;
use App\Service\AutomatedDates;
use App\Form\DecisionEditionType;
use App\Form\DecisionCreationType;
use App\Repository\CommentRepository;
use App\Repository\DecisionRepository;
use App\Repository\InteractionRepository;
use App\Security\DecisionVoter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_MEMBER')]
class DecisionController extends AbstractController
{
    private const UP_VOTE = "upVote";
    private const DOWN_VOTE = "downVote";

    #[Route('/decision/creation', name: 'app_decision_creation')]
    public function new(
        Request $request,
        DecisionRepository $decisionRepository,
        AutomatedDates $automatedDates
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
        Voting $voting,
        DecisionVoter $decisionVoter
    ): Response {
        /** @var \App\Entity\User */
        $user = $this->getUser();

        $interaction = $interactionRepo->findOneBy([
            'decision' => $decision,
            'user' => $user,
        ]);

        if ($this->isCsrfTokenValid('vote' . $user->getId(), $request->request->get('_token'))) {
            $this->denyAccessUnlessGranted('vote', $decision);
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
            'upVotes' => $voting->countUpVotes($decision),
            'downVotes' => $voting->countDownVotes($decision),
            'canVote' => $decisionVoter->canVote($decision, $user)
        ]);
    }

    #[Route('decision/modifier/{decision}', methods: ['GET', 'POST'], name: 'app_decision_edit')]
    public function edit(Decision $decision, Request $request, DecisionRepository $decisionRepository,): Response
    {
        $this->denyAccessUnlessGranted('edit', $decision);

        $form = $this->createForm(DecisionEditionType::class, $decision);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $decisionRepository->save($decision, true);

            return $this->redirectToRoute('app_decision', ['decision' => $decision->getId()]);
        }

        return $this->renderForm('decisions/edit.html.twig', [
            'decision' => $decision,
            'form' => $form
        ]);
    }


    #[Route('decision/{decision}/avis', methods: ['GET', 'POST'], name: 'app_decision_comment')]
    public function comment(
        Decision $decision,
        Request $request,
        CommentRepository $commentRepository,
    ): Response {

        /**  @var \App\Entity\User */
        $user = $this->getUser();

        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setUser($user);
            $comment->setDecision($decision);
            $commentRepository->save($comment, true);
            return $this->redirectToRoute('app_decision', ['decision' => $decision->getId()]);
        }


        return $this->render('decisions/commentView.html.twig', [
            'decision' => $decision,
            'commentForm' => $form->createView(),
        ]);
    }
}
