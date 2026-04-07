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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
