<?php

namespace App\Controller;
use App\Repository\PublicationRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Publication;
use App\Form\PublicationType;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GesPublicationController extends AbstractController
{
    #[Route('/ges/publication/test', name: 'app_ges_publication')]
    public function index(): Response
    {
        return $this->render('ges_publication/index.html.twig', [
            'controller_name' => 'GesPublicationController',
        ]);
    }

    #[Route('/ges/publication/liste', name: 'app_publication_liste')]
    public function Publication(PublicationRepository $repos): Response
    {
        $Publication = $repos->findAll();
        
        return $this->render('ges_publication/publication.html.twig', [
            'pub' => $Publication,
        ]);
    }


    #[Route('/ges/publication/add', name: 'app_add_publication')]
    public function new(EntityManagerInterface $em,Request $request): Response
    {
        $Publication = new Publication();
        // ...

        $form = $this->createForm(PublicationType::class, $Publication);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $Equipement = $form->getData();

            $em->persist($Publication);
            $em->flush();

            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('app_publication_liste');
        }

        return $this->renderForm('ges_publication/addPublication.html.twig', [
            'form' => $form,
        ]);
    }
}
