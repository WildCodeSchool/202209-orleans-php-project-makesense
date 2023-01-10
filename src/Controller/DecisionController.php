<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Decision;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\InteractionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DecisionController extends AbstractController
{
    #[Route('decision/{decision}', methods: ['GET'], name: 'app_decision')]
    public function index(Decision $decision): Response
    {
        return $this->render('decisions/decisionView.html.twig', [
            'decision' => $decision,
        ]);
    }


    #[Route('decision/{decision}/avis', methods: ['GET'], name: 'app_decision_comment')]
    public function comment(
        Decision $decision,
        Request $request,
        CommentRepository $commentRepository,
        InteractionRepository $interactRepository,
        Security $security,
    ): Response {

        /**  @var \App\Entity\User */
        $user = $security->getUser();
        $userId = $user->getId();



        $decisionId =  $decision->getId();



        $interaction = $interactRepository->findByUserAndDecision($userId, $decisionId);



        $comment = new Comment();




        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);



        if ($interaction) {
            $comment->setInteraction($interaction[0]);
        } else {
            $interactRepository->findByUserAndDecision($userId, $decisionId);
        }




        if ($form->isSubmitted() && $form->isValid()) {
            $commentRepository->save($comment, true);
        }





        return $this->render('decisions/commentView.html.twig', [
            'decision' => $decision,
            'commentForm' => $form->createView(),
        ]);
    }
}
