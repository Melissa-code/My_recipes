<?php

namespace App\Controller;

use App\Repository\FoodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminFoodController extends AbstractController
{
    #[Route('/admin/food', name: 'app_admin_food')]
    public function index(FoodRepository $foodRepository): Response
    {
        $food = $foodRepository->findAll();
        //dump($food); die;

        return $this->render('admin/admin_food/adminFood.html.twig', [
           'food' => $food,
        ]);
    }
}
