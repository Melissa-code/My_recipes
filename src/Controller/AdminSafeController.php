<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminSafeController extends AbstractController
{
    #[Route('/signup', name: 'app_signup')]
    public function login(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $user = new User();
        $form = $this->createForm(LoginType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $managerRegistry->getManager()->persist($user);
            $managerRegistry->getManager()->flush();
            return $this->redirectToRoute('app_food');
        }

        return $this->render('admin_safe/signup.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
