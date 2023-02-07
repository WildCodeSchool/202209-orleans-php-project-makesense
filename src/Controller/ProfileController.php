<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use PhpParser\Node\Expr\New_;
use Doctrine\ORM\Mapping\Entity;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_MEMBER')]
class ProfileController extends AbstractController
{
    #[Route('/mon-profil', name: 'app_view_my_profil')]
    public function index(
        Request $request,
        UserRepository $userRepository,
    ): Response {


        /** @var User */
        $user = $this->getUser();

        $form = $this->createForm(ProfileType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);
        }

        return $this->render('view_my_profil/index.html.twig', [
            'profileForm' => $form->createView(),
            'user' => $user,

        ]);
    }

    #[Route('/profil/{user}', name: 'app_view_you_profil')]
    public function show(
        Request $request,
        UserRepository $userRepository,
        User $user
    ): Response {



        $form = $this->createForm(ProfileType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);
        }

        return $this->render('view_my_profil/profil.html.twig', [
            'profileForm' => $form->createView(),
            'user' => $user,

        ]);
    }
}
