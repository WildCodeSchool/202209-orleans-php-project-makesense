<?php

namespace App\Controller;

use App\Entity\Decision;
use App\Form\DecisionCreationType;
use App\Repository\DecisionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
class DecisionCreationController extends AbstractController
{
    #[Route('/decision/creation', name: 'app_decision_creation')]
    public function index(Request $request, DecisionRepository $decisionRepository): Response
    {
        $decision = new Decision();

        $form = $this->createForm(DecisionCreationType::class, $decision);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $decisionRepository->save($decision, true);

            return $this->redirectToRoute('app_home');
        }


        return $this->renderForm('decision_creation/index.html.twig', [
            'form' => $form,
        ]);
    }
}
