<?php

namespace App\Controller;

use App\Entity\Category;
use DateTime;
use App\Form\DecisionSearchType;
use Doctrine\ORM\Mapping\Entity;
use App\Repository\CategoryRepository;
use App\Repository\DecisionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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

    #[Route('/toutes-les-decisions', name: 'app_allDecisions')]
    public function showAll(
        DecisionRepository $decisionRepository,
        Request $request,
        CategoryRepository $categoryRepository,
    ): Response {

        $form = $this->createForm(DecisionSearchType::class);

        $form->handleRequest($request);

        $categories = $categoryRepository->findBy([], ['name' => 'ASC']);

         /**  @var \App\Entity\Category */
        $category = new Category();

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
        }


        $decisions = $decisionRepository->decisionSearchCategory($data['input'],  ?? '');

        return $this->renderForm('decisions/allDecisions.html.twig', [
            'decisions' => $decisions,
            'form' => $form,
            'categories' => $categories,

        ]);
    }
}
