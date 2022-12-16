<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilUserController extends AbstractController
{
    #[Route('/profil/user', name: 'app_profil_user')]
    public function index(): Response
    {
        return $this->render('profil_user/index.html.twig', [
            'controller_name' => 'ProfilUserController',
        ]);
    }
}
