<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;

class AdminSafeController extends AbstractController
{
    /**
     * Sign up
     *
     * @param Request $request
     * @param ManagerRegistry $managerRegistry
     * @param UserPasswordHasherInterface $passwordHasher
     * @return Response
     */
    #[Route('/signup', name: 'app_signup')]
    public function signup(Request $request, ManagerRegistry $managerRegistry, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(LoginType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);
            $managerRegistry->getManager()->persist($user);
            $managerRegistry->getManager()->flush();
            return $this->redirectToRoute('app_food');
        }

        return $this->render('admin_safe/signup.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Login
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('admin_safe/login.html.twig', [
            "error" => $error,
            "lastUsername" => $lastUsername
        ]);
    }

    /**
     * Logout
     *
     */
    #[Route('/logout', name: 'app_logout')]
    public function logout(): Response
    {
    }

}
