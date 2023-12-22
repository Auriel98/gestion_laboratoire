<?php

namespace App\Controller;

use App\Entity\Equipement;
use App\Form\EquipementType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\EquipementRepository;


use Doctrine\ORM\EntityManagerInterface;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GesEquipementController extends AbstractController
{

    #[Route('/ges/equipement/liste', name: 'app_equipement_liste')]
    public function liste(EquipementRepository $repos): Response
    {
        $Equipement = $repos->findAll();
       // dd($Equipement);
        
       // $user = $this->getUser();
        return $this->render('ges_equipement/list.html.twig', [
            'equipmt' => $Equipement,
        ]);
    }




    #[Route('/ges/equipement', name: 'app_ges_equipement')]
    public function new(EntityManagerInterface $em,Request $request): Response
    {
        $Equipement = new Equipement();
        // ...

        $form = $this->createForm(EquipementType::class, $Equipement);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $Equipement = $form->getData();

            $em->persist($Equipement);
            $em->flush();

            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('app_equipement_liste');
        }

        return $this->renderForm('ges_equipement/add.html.twig', [
            'form' => $form,
        ]);
    }


    #[Route('/ges/equipement/delete/{id}', name: 'app_Equipement_delete')]
    public function delete($id,EquipementRepository $repos,EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $Equipement = $repos->find($id);
       if(!$Equipement)
       {

       }
       $em->remove($Equipement);
       $em->flush(); 
       $this->addFlash('warning','Equipement supprimer avec succes...');
        return $this->redirectToRoute('app_equipement_liste');
    }
}
