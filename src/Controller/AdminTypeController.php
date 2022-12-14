<?php

namespace App\Controller;

use App\Entity\Type;
use App\Form\TypeType;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminTypeController extends AbstractController
{
    /**
     * Get all the types
     *
     * @param TypeRepository $typeRepository
     * @return Response
     */
    #[Route('/admin/type', name: 'app_admin_type')]
    public function getAll(TypeRepository $typeRepository): Response
    {
        $types = $typeRepository->findAll();

        return $this->render('admin/admin_type/adminType.html.twig', [
            "types"=> $types,
        ]);
    }


    #[Route('/admin/type/{id}', name: 'app_update_type', methods: 'GET|POST')]
    public function updateOrCreateType(Type $type, Request $request): Response
    {
        $form = $this->createForm(TypeType::class, $type);



        return $this->render('admin/admin_type/adminCreateUpdate.html.twig', [

        ]);
    }
}
