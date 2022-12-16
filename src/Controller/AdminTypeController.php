<?php

namespace App\Controller;

use App\Entity\Type;
use App\Form\TypeType;
use App\Repository\TypeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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

    /**
     * Create or Update a type
     *
     * @param $slugger
     * @param Type|null $type
     * @param Request $request
     * @param ManagerRegistry $managerRegistry
     * @return Response
     */
    #[Route('/admin/type/create', name: 'app_create_type', methods: 'GET|POST')]
    #[Route('/admin/type/{id}', name: 'app_update_type', methods: 'GET|POST')]
    public function updateOrCreateType(SluggerInterface $slugger, Type $type = null, Request $request, ManagerRegistry $managerRegistry): Response
    {
        if(!$type) {
            $type = new Type();
        };

        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            // Get the uploaded image file
            $imageFile = $form->get('imageFile')->getData();
            // Check if the image file is valid
            if($imageFile){
                $imageFileOriginal = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // Reformat the image file name to be conform to an URL (without special chars) with Slugger interface
                $imageFileReformat = $slugger->slug($imageFileOriginal);
                // Create a unique name & unique id for the image file
                $imageName = $imageFileReformat.'-'.uniqid().'-'.$imageFile->getExtension();

                // Move the image file to a specific directory in the server
                try {
                    $imageFile->move(
                        $this->getParameter('repertoire_images_type'),
                        $imageName
                    );
                } catch(FileException $e) {
                    throw $e;
                }

                // Save the name of the image file only
                $type->setImage($imageName);
            }

            $isUpdating = $type->getId() !== null;
            $managerRegistry->getManager()->persist($type);
            $managerRegistry->getManager()->flush();
            $this->addFlash('success', ($isUpdating) ?'La modification du type '.$type->getName().' a bien été effectuée.' : 'L\'ajout du type '.$type->getName().' a bien été effectué.' );
            return $this->redirectToRoute('app_admin_type');
        }

        return $this->render('admin/admin_type/adminCreateUpdate.html.twig', [
            "type" =>$type,
            "form" => $form->createView(),
            "isUpdating" => $type->getId() !== null
        ]);
    }

    /**
     * Delete a type
     *
     * @param ManagerRegistry $managerRegistry
     * @param Type $type
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/type{id}', name: 'app_delete_type', methods: 'DEL')]
    public function deleteType(ManagerRegistry $managerRegistry, Type $type, Request $request): Response
    {
        $image = $this->getParameter('repertoire_images_type').'/'. $type->getImage();

        if ($this->isCsrfTokenValid('REM' . $type->getId(), $request->get('_token'))) {
            $managerRegistry->getManager()->remove($type);
            $managerRegistry->getManager()->flush();
            if($image){
                if (file_exists($image)) {
                    unlink($image);
                }
            }
            $this->addFlash('success', 'La suppression du type ' . $type->getName() . ' a bien été effectuée.');
            return $this->redirectToRoute('app_admin_type');
        }
    }


}
