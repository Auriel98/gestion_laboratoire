<?php

namespace App\Controller;
use App\Repository\ProjetRepository;
use App\Entity\Projet;
use App\Entity\Chercheur;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;



use App\Form\ProjetType;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GesProjetController extends AbstractController
{
    #[Route('/ges/p', name: 'appp_ges_projet')]
    public function index(): Response
    {
        return $this->render('ges_projet/index.html.twig', [
            'controller_name' => 'GesProjetController',
        ]);
    }

    #[Route('/ges/projet', name: 'app_gest_projet')]
    public function Projet(ProjetRepository $repos): Response
    {
        $Projet = $repos->findAll();
    
        return $this->render('ges_projet/projet.html.twig', [
            'projets' => $Projet,
        ]);
    }


    #[Route('/ges/projet/add', name: 'app_add_projet')]
    public function new(EntityManagerInterface $em,Request $request): Response
    {
        $Projet = new Projet();
        // ...

        $form = $this->createForm(ProjetType::class, $Projet);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $Equipement = $form->getData();

            $em->persist($Projet);
            $em->flush();

            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('app_gest_projet');
        }

        return $this->renderForm('ges_projet/addProjet.html.twig', [
            'form' => $form,
        ]);
    }


    #[Route('/ges/projet/delete/{id}', name: 'app_projet_delete')]
    public function delete($id,ProjetRepository $repos,EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $Projet = $repos->find($id);
       if(!$Projet)
       {

       }
       $em->remove($Projet);
       $em->flush(); 
       $this->addFlash('warning','Equipement supprimer avec succes...');
        return $this->redirectToRoute('app_gest_projet');
    }
}

    

    

