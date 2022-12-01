<?php

namespace App\Controller;

use App\Entity\Food;
use App\Repository\FoodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FoodController extends AbstractController
{
    /**
     * @param FoodRepository $foodRepository
     * @return Response with all the food
     */

    #[Route('/', name: 'app_food')]
    public function food(FoodRepository $foodRepository): Response
    {
        $food = $foodRepository->findAll();

        return $this->render('food/food.html.twig', [
            'food' => $food,
            'isCalorie' => false,
            'isCarbohydrate' => false,
            'isLipid' => false
        ]);
    }

    /**
     * @param FoodRepository $foodRepository
     * @param float $calorie
     * @return Response with lower calorie food
     */
    #[Route('/aliments/calorie/{calorie}', name: 'app_foodPerCalorie')]
    public function lowerCalorieFood(FoodRepository $foodRepository, float $calorie): Response
    {
        $food = $foodRepository->getFoodPerProperty('calorie', '<', $calorie);

        return $this->render('food/food.html.twig', [
            'food' => $food,
            'isCalorie'=> true
        ]);
    }

    /**
     * @param FoodRepository $foodRepository
     * @param float $carbohydrate
     * @return Response with lower carbohydrate food
     */
    #[Route('/aliments/glucide/{carbohydrate}', name: 'app_foodPerCarbohydrate')]
    public function lowerCarbohydrateFood(FoodRepository $foodRepository, float $carbohydrate): Response
    {
        $food = $foodRepository->getFoodPerProperty('carbohydrate', '<', $carbohydrate);

        return $this->render('food/food.html.twig', [
            'food' => $food,
            'isCalorie'=> false,
            'isCarbohydrate'=> true
        ]);
    }

    #[Route('/aliments/lipide/{lipid}', name: 'app_foodPerLipid')]
    public function lowerLipidFood(FoodRepository $foodRepository, float $lipid): Response
    {
        $food = $foodRepository->getFoodPerProperty('lipid', '<=', $lipid);

        return $this->render('food/food.html.twig', [
            'food' => $food,
            'isCalorie' => false,
            'isCarbohydrate' => false,
            'isLipid' => true
        ]);
    }



    /**
     * @param Food $food
     * @return Response with a food
     */
    #[Route('/ingredient/{id}', name: 'app_ingredient')]
    public function ingredient(Food $food): Response
    {
        return $this->render('food/ingredient.html.twig', [
            'food' => $food,
        ]);
    }
}
