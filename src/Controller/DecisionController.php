<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Decision;
use App\Entity\Interaction;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\InteractionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
        InteractionRepository $interactionRepository
    ): Response {


       /*  $interaction = $interactionRepository->findBy(['interaction' => 'id']); */

        $comment = new Comment();

/* dd($decision->getId());
        $decision->getId(); */


        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);
        
        
        
        
        if ($form->isSubmitted() && $form->isValid()) {
          /*   $comment->setInteraction($interaction); */
            $commentRepository->save($comment, true);
        }





        return $this->render('decisions/commentView.html.twig', [
            'decision' => $decision,
            'commentForm' => $form->createView(),
        ]);
    }
}
