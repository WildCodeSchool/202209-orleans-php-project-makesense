<?php

namespace App\Controller;

use App\Form\DecisionSearchType;
use App\Repository\DecisionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

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

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $decisions = $decisionRepository->decisionSearch($data['input']);
        }

        return $this->renderForm(
            'home/index.html.twig',
            [
                'decisions' => $decisions,
                'form' => $form
            ],
        );
    }
}
