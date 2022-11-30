<?php

namespace App\Controller;

use App\Entity\Food;
use App\Repository\FoodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FoodController extends AbstractController
{
    #[Route('/', name: 'app_food')]
    public function food(FoodRepository $foodRepository): Response
    {
        $food = $foodRepository->findAll();

        return $this->render('food/food.html.twig', [
            'food' => $food,
            'isCalorie' => false
        ]);
    }

    #[Route('/aliments/{calorie}', name: 'app_foodPerCalorie')]
    public function lowerCalorieFood(FoodRepository $foodRepository, $calorie)
    {
        $food = $foodRepository->getFoodPerCalorie($calorie);

        return $this->render('food/food.html.twig', [
            'food' => $food,
            'isCalorie'=> true
        ]);
    }

    #[Route('/ingredient/{id}', name: 'app_ingredient')]
    public function ingredient(Food $food): Response
    {
        return $this->render('food/ingredient.html.twig', [
            'food' => $food,
        ]);
    }
}
