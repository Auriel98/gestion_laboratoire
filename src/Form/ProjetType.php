<?php

namespace App\Form;

use App\Entity\Projet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('dateDebut')
            ->add('dateFin')
            ->add('etatAvancement')
            ->add('chercheurs', EntityType::class, [
                'class' => 'App\Entity\Chercheur',
                'choice_label' => 'Id', // Remplacez 'nom' par le champ que vous souhaitez afficher dans la liste déroulante
                'multiple' => true, // Si vous souhaitez permettre la sélection de plusieurs chercheurs
                'expanded' => true, // Si vous souhaitez afficher une liste déroulante ou une liste de cases à cocher
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }

    
}
