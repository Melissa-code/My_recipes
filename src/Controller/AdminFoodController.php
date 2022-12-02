<?php

namespace App\Controller;

use App\Entity\Food;
use App\Form\FoodType;
use App\Repository\FoodRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminFoodController extends AbstractController
{
    /**
     * @param FoodRepository $foodRepository
     * @return Response
     */
    #[Route('/admin/food', name: 'app_admin_food')]
    public function food(FoodRepository $foodRepository): Response
    {
        $food = $foodRepository->findAll();
        //dump($food); die;

        return $this->render('admin/admin_food/adminFood.html.twig', [
           'food' => $food,
        ]);
    }

    /**
     * @param Food $food
     * @return Response
     */
    #[Route('/admin/food/{id}', name: 'app_update_ingredient')]
    public function updateIngredient(Food $food, Request $request, ManagerRegistry $managerRegistry)
    {
        $form = $this->createForm(FoodType::class, $food);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $managerRegistry->getManager()->persist($food);
            $managerRegistry->getManager()->flush();
            return $this->redirectToRoute('app_admin_food');
        }

        return $this->render('admin/admin_food/adminUpdate.html.twig', [
            'food' => $food,
            'form' => $form->createView()
        ]);


    }


}
