<?php

namespace App\Form;

use App\Entity\Stage;
use App\Entity\Eleve;
use App\Entity\Entreprise;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('eleve', EntityType::class, [
                'class' => Eleve::class,
                'choice_label' => function(Eleve $e) { return $e->getPrenom() . ' ' . $e->getNom(); },
                'placeholder' => 'Choisir un élève',
            ])
            ->add('entreprise', EntityType::class, [
                'class' => Entreprise::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisir une entreprise',
            ])
            ->add('dateDebut', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('dateFin', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
