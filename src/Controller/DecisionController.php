<?php

namespace App\Controller;

use App\Entity\Decision;
use App\Service\AutomatedDates;
use App\Form\DecisionCreationType;
use App\Repository\DecisionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DecisionController extends AbstractController
{
    #[Route('/decision/creation', name: 'app_decision_creation')]
    public function new(
        Request $request,
        DecisionRepository $decisionRepository,
        AutomatedDates $automatedDates
    ): Response {
        $decision = new Decision();

        $form = $this->createForm(DecisionCreationType::class, $decision);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
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
    public function index(Decision $decision): Response
    {
        return $this->render('decisions/decisionView.html.twig', ['decision' => $decision,]);
    }
}
