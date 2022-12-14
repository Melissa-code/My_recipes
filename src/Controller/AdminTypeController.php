<?php

namespace App\Controller;

use App\Entity\Type;
use App\Form\TypeType;
use App\Repository\TypeRepository;
use Doctrine\Persistence\ManagerRegistry;
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

    #[Route('/admin/type/create', name: 'app_create_type', methods: 'GET|POST')]
    #[Route('/admin/type/{id}', name: 'app_update_type', methods: 'GET|POST')]
    public function updateOrCreateType(Type $type = null, Request $request, ManagerRegistry $managerRegistry): Response
    {
        if(!$type) {
            $type = new Type();
        };

        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $isUpdating = $type->getId() !== null;
            $managerRegistry->getManager()->persist($type);
            $managerRegistry->getManager()->flush();
            $this->addFlash('success', ($isUpdating) ?'La modification du type '.$type->getName().' a bien été effectuée.' : 'L\'ajout du type '.$type->getName().' a bien été effectué.' );
            return $this->redirectToRoute('app_admin_type');
        }

        return $this->render('admin/admin_type/adminCreateUpdate.html.twig', [
            "type" =>$type,
            "form" => $form->createView()
        ]);
    }
}
