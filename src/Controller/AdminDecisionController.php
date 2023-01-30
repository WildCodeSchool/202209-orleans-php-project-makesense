<?php

namespace App\Controller;

use App\Entity\Decision;
use App\Repository\DecisionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/decision')]
class AdminDecisionController extends AbstractController
{
    #[Route('/', name: 'app_admin_decision_index', methods: ['GET'])]
    public function index(DecisionRepository $decisionRepository): Response
    {
        return $this->render('admin_decision/index.html.twig', [
            'decisions' => $decisionRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_admin_decision_show', methods: ['GET'])]
    public function show(Decision $decision): Response
    {
        return $this->render('admin_decision/show.html.twig', [
            'decision' => $decision,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_decision_delete', methods: ['POST'])]
    public function delete(Request $request, Decision $decision, DecisionRepository $decisionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $decision->getId(), $request->request->get('_token'))) {
            $decisionRepository->remove($decision, true);
        }

        return $this->redirectToRoute('app_admin_decision_index', [], Response::HTTP_SEE_OTHER);
    }
}
