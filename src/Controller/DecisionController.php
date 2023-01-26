<?php

namespace App\Controller;

use App\Entity\Decision;
use App\Entity\Interaction;
use App\Service\AutomatedDates;
use Symfony\Component\Mime\Email;
use App\Form\DecisionCreationType;
use App\Repository\DecisionRepository;
use App\Repository\InteractionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
        Security $security,
        MailerInterface $mailer,
        InteractionRepository $interactionRepo,
    ): Response {

        $decision = new Decision();

        $form = $this->createForm(DecisionCreationType::class, $decision);

        /** @var \App\Entity\User */
        $user = $security->getUser();

        $form->handleRequest($request);
        $impactedUsers = $form->getData()->getInteractions();

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

            foreach ($impactedUsers as $impactedUser) {
                $impactedUserRole =  $impactedUser->getDecisionRole();
                $email = (new Email())

                    ->from($this->getParameter('mailer_from'))

                    ->to($impactedUser->getUser()->getEmail())

                    ->subject('Une nouvelle décision vient d\'être publiée !')

                    ->html($this->renderView('email/impact.html.twig', [
                        'decision' => $decision,
                        'impactedUser' => $impactedUser,
                        'impactedUserRole' => $impactedUserRole,
                    ]));
                $mailer->send($email);
            }

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
}
