<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminAdminFoodController extends AbstractController
{
    #[Route('/admin/admin/food', name: 'app_admin_admin_food')]
    public function index(): Response
    {
        return $this->render('admin_admin_food/index.html.twig', [
            'controller_name' => 'AdminAdminFoodController',
        ]);
    }
}
