<?php

namespace App\Controller;

use DateTimeInterface;
use App\Form\DecisionSearchType;
use App\Repository\DecisionRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(DecisionRepository $decisionRepository, Request $request): Response
    {
        $form = $this->createForm(DecisionSearchType::class);

        $form->handleRequest($request);

        $decisions = $decisionRepository->findBy(
            [],
            ['decisionStartTime' => 'DESC'],
            12
        );

        $today = new DateTime('today');
        $decisionsEndingSoon = $decisionRepository->findDecisionFinishedSoon($today);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $decisions = $decisionRepository->decisionSearch($data['input']);
        }

        return $this->renderForm(
            'home/index.html.twig',
            [
                'decisions' => $decisions,
                'decisionsEndingSoon' => $decisionsEndingSoon,
                'form' => $form
            ],
        );
    }
}
