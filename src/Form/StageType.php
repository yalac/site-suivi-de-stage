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
use Symfony\Component\Form\Extension\Core\Type\TextType;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('descriptifStage', null, [
                'label' => 'Descriptif du stage',
                'required' => false,
            ])
            ->add('dateDebutStage', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de début',
                'required' => false,
            ])
            ->add('dateFinStage', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de fin',
                'required' => false,
            ])
            ->add('dureeStage', null, [
                'label' => 'Durée (jours)',
                'required' => false,
            ])
            ->add('entrepriseStage', EntityType::class, [
                'class' => Entreprise::class,
                'choice_label' => 'nomEntreprise',
                'placeholder' => 'Choisir une entreprise',
                'label' => 'Entreprise',
            ])
            ->add('eleves', EntityType::class, [
                'class' => Eleve::class,
                'choice_label' => function ($eleve) {
                    return $eleve->getPrenomEleve() . ' ' . $eleve->getNomEleve();
                },
                'placeholder' => 'Choisir un élève',
                'label' => 'Élève',
                'property_path' => 'elevePrincipalStage',
                'required' => false,
            ])
            ->add('profReferent', TextType::class, [
                'label' => 'Prof référent',
                'required' => false,
            ])
            ->add('profVisite', TextType::class, [
                'label' => 'Prof de visite',
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
