<?php

namespace App\Controller;

use App\Entity\Food;
use App\Form\FoodType;
use App\Repository\FoodRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminFoodController extends AbstractController
{
    /**
     * Get food function
     *
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
     * Create or update food function
     *
     * @param Food $food
     * @return Response
     */
    #[Route('/admin/food/create', name: 'app_create_ingredient')]
    #[Route('/admin/food/{id}', name: 'app_update_ingredient', methods: 'GET|POST')]
    public function createOrUpdateIngredient(Food $food = null, Request $request, ManagerRegistry $managerRegistry)
    {
        if(!$food) {
            $food = new Food();
        }

        $form = $this->createForm(FoodType::class, $food);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $isUpdating = $food->getId() !== null;
            $managerRegistry->getManager()->persist($food);
            $managerRegistry->getManager()->flush();
            $this->addFlash('success', ($isUpdating) ?'La modification de l\'aliment '.$food->getName().' a bien été effectuée.' : 'L\'ajout de l\'aliment '.$food->getName().' a bien été effectué.' );
            return $this->redirectToRoute('app_admin_food');
        }

        return $this->render('admin/admin_food/adminCreateUpdate.html.twig', [
            'food' => $food,
            'form' => $form->createView(),
            'isUpdating' => $food->getId() !== null
        ]);
    }


    /**
     * Delete food function
     *
     * @param Food $food
     * @param Request $request
     * @param ManagerRegistry $managerRegistry
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    #[Route('/admin/food/{id}', name: 'app_delete', methods: 'DEL')]
    public function deleteIngredient(Food $food, Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        if($this->isCsrfTokenValid("REM".$food->getId(), $request->get("_token"))) {
            $entityManager->remove($food);
            $entityManager->flush();
            $this->addFlash('success', 'La suppression de l\'aliment '.$food->getName().' a bien été effectuée.');
            return $this->redirectToRoute('app_admin_food');
        }
    }


}
