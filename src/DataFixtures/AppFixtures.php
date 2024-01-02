<?php

namespace App\DataFixtures;

use App\Entity\Chercheur;
use App\Entity\Publication;
use App\Entity\Projet;
use App\Entity\Equipement;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Chargement des données pour l'entité Chercheur
        $chercheur1 = new Chercheur();
        $chercheur1->setNom("administrateur");
        $chercheur1->setPrenom("Admin");
        $chercheur1->setEmail("Admin@example.com");
        // Hachage du mot de passe
        $mot_de_passe_hache = password_hash("motdepasse1", PASSWORD_DEFAULT);
        $chercheur1->setPassword($mot_de_passe_hache);

        $chercheur1->setRoles(["ROLE_ADMIN"]);

        $manager->persist($chercheur1);

        $chercheur2 = new Chercheur();
        $chercheur2->setNom("chercheurs1");
        $chercheur2->setPrenom("chercheur1");
        $chercheur2->setEmail("chercheur@example.com");
        // Hachage du mot de passe
        $mot_de_passe_hache = password_hash("motdepasse2", PASSWORD_DEFAULT);
        $chercheur2->setPassword($mot_de_passe_hache);

        $chercheur2->setRoles(["ROLE_USER"]);
        $manager->persist($chercheur2);

        $chercheur3 = new Chercheur();
        $chercheur3->setNom("chercheurs3");
        $chercheur3->setPrenom("chercheur3");
        $chercheur3->setEmail("chercheur3@example.com");
        // Hachage du mot de passe
        $mot_de_passe_hache = password_hash("motdepasse3", PASSWORD_DEFAULT);
        $chercheur3->setPassword($mot_de_passe_hache);

        $chercheur3->setRoles(["ROLE_USER"]);
        $manager->persist($chercheur3);


        // Chargement des données pour l'entité Projet
        for ($i = 0; $i < 10; $i++) {
            $projet = new Projet();
            $projet->setTitre("Projet de recherche n°" . ($i + 1));
            $projet->setDescription("Description du projet n°" . ($i + 1));
            $projet->setDateDebut(new \DateTime("2023-08-01"));
            $projet->setDateFin(new \DateTime("2023-12-31"));
            $projet->setEtatAvancement("En cours");

            // Ajout des chercheurs au projet
            //$chercheurs = $manager->getRepository(Chercheur::class)->findAll();
            //$projet->setChercheurs($chercheurs);

            $manager->persist($projet);}

           // Chargement des données pour l'entité Equipement
        for ($i = 0; $i < 10; $i++) {
            $equipement = new Equipement();
            $equipement->setNom("Equipement n°" . ($i + 1));
            $equipement->setDescription("Description de l'équipement n°" . ($i + 1));

            // Assigne l'état aléatoire
            $etat = rand(0, 1);
            $equipement->setEtat($etat);

            $manager->persist($equipement);
        }


        // Chargement des données pour l'entité Publication

        $chercheurs = $manager->getRepository(Chercheur::class)->findAll();

        if (!empty($chercheurs)) {
            shuffle($chercheurs);

            for ($i = 0; $i < 10; $i++) {
                $publication = new Publication();
                $publication->setTitre("Publication n°" . ($i + 1));
                $publication->setDate(new \DateTime());
                $publication->setContenu("Contenu de la publication n°" . ($i + 1));

                // Assigne le chercheur aléatoire
                $index = array_rand($chercheurs);
                $publication->setPublicationChercheur($chercheurs[$index]);

                $manager->persist($publication);
            }
        }
        $manager->flush();
    }
}
