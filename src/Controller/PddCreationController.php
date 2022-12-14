<?php

namespace App\Controller;

use App\Entity\Decision;
use App\Form\PddCreationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PddCreationController extends AbstractController
{
    #[Route('/pdd/creation', name: 'app_pdd_creation')]
    public function index(): Response
    {
        $decision = new Decision();

        $form = $this->createForm(PddCreationType::class, $decision);

        return $this->renderForm('pdd_creation/index.html.twig', [
            'form' => $form,
        ]);
    }
}
