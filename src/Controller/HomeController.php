<?php

namespace App\Controller;

use DateTime;
use App\Form\DecisionSearchType;
use App\Repository\DecisionRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_MEMBER')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(DecisionRepository $decisionRepository, Request $request): Response
    {
        $form = $this->createForm(DecisionSearchType::class);

        $form->handleRequest($request);

        $today = new DateTime('today');

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
        }
        $decisions = $decisionRepository->decisionSearch($data['input'] ?? '');
        $decisionsFinished = $decisionRepository->findDecisionFinished($today, $data['input'] ?? '');
        $decisionsEndingSoon = $decisionRepository->findDecisionFinishedSoon($today, $data['input'] ?? '');

        return $this->renderForm(
            'home/index.html.twig',
            [
                'decisions' => $decisions,
                'decisionsFinished' => $decisionsFinished,
                'decisionsEndingSoon' => $decisionsEndingSoon,
                'form' => $form
            ],
        );
    }
}
