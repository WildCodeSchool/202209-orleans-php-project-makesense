<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Decision;
use App\Form\CommentType;
use App\Entity\Interaction;
use App\Service\AutomatedDates;
use App\Form\DecisionCreationType;
use App\Repository\CommentRepository;
use App\Repository\DecisionRepository;
use App\Repository\InteractionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
class DecisionController extends AbstractController
{
    #[Route('/decision/creation', name: 'app_decision_creation')]
    public function new(
        Request $request,
        DecisionRepository $decisionRepository,
        AutomatedDates $automatedDates,
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

    #[Route('decision/{decision}', methods: ['GET'], name: 'app_decision')]
    public function index(Decision $decision, InteractionRepository $interactionRepo): Response
    {
        $impactedUsers = $interactionRepo->findBy([
            'decision' => $decision,
            'decisionRole' => Interaction::DECISION_IMPACTED,
        ]);

        $expertUsers = $interactionRepo->findBy([
            'decision' => $decision,
            'decisionRole' => Interaction::DECISION_EXPERT,
        ]);

        return $this->render('decisions/decisionView.html.twig', [
            'decision' => $decision,
            'impactedUsers' => $impactedUsers,
            'expertUsers' => $expertUsers
        ]);
    }

    #[Route('decision/{decision}/ecrire-un-avis', methods: ['GET', 'POST'], name: 'app_decision_comment')]
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
            return $this->redirectToRoute('app_decision_commentView', ['decision' => $decision->getId()]);
        }


        return $this->render('decisions/commentCreateView.html.twig', [
            'decision' => $decision,
            'commentForm' => $form->createView(),
        ]);
    }


    #[Route('decision/{decision}/avis', name: 'app_decision_commentView')]
    public function commentView(
        Decision $decision,
        CommentRepository $commentRepository,
    ): Response {
        $comments = $commentRepository->findBy(
            [
                'decision' => $decision,
            ]
        );

        $commentsFirst = [];
        $commentsConflict = [];
        $commentsFinal = [];
        foreach ($comments as $comment) {
            if (
                $comment->getCommentTimedate() > $decision->getDecisionStartTime()
                && $comment->getCommentTimedate() <= $decision->getFirstDecisionEndDate()
            ) {
                $commentsFirst[] = $comment;
            } elseif (
                $comment->getCommentTimedate() > $decision->getFirstDecisionEndDate()
                && $comment->getCommentTimedate() <= $decision->getConflictEndDate()
            ) {
                $commentsConflict[] = $comment;
            } elseif (
                $comment->getCommentTimedate() > $decision->getConflictEndDate()
                &&  $comment->getCommentTimedate() <= $decision->getFinalDecisionEndDate()
            ) {
                $commentsFinal[] = $comment;
            }
        };

        $decisionFirst = $decision->getDecisionStartTime();
        $decisionConflict = $decision->getFirstDecisionEndDate();
        $decisionFinal = $decision->getConflictEndDate();

        return $this->render(
            'decisions/commentView.html.twig',
            [
                'decision' => $decision,
                'comments' => $comments,
                'commentsFirstPeriods' => $commentsFirst,
                'commentsConflictPeriods' => $commentsConflict,
                'commentsFinalPeriods' => $commentsFinal,
                'decisionFirstPeriod' => $decisionFirst,
                'decisionConflictPeriod' => $decisionConflict,
                'decisionFinalPeriod' => $decisionFinal,
            ]
        );
    }
}
