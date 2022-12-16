<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ViewMyProfilController extends AbstractController
{
    #[Route('/profil/mon-profil', name: 'app_view_my_profil')]
    public function index(): Response
    {


        return $this->render('view_my_profil/index.html.twig', [
            'controller_name' => 'ViewMyProfilController',
        ]);
    }
}
