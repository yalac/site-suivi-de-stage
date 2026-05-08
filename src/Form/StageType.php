<?php

namespace App\Form;

use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Eleve;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('eleveStage', EntityType::class, [
            'class' => Eleve::class,
            'choice_label' => fn(Eleve $eleve) => $eleve->getNomEleve() . ' ' . $eleve->getPrenomEleve(),
            'placeholder' => 'Choisir un élève',
            'label' => 'Élève',
        ])
        ->add('dateDebutStage', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de début'
            ])
            ->add('dateFinStage', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de fin'
            ])
            ->add('descriptifStage', null, [
                'label' => 'Petite description (Pas obligatoire)',
                'required' => false,
            ])
            ->add('entrepriseStage', EntityType::class, [
                'class' => Entreprise::class,
                'choice_label' => 'nomEntreprise',
                'placeholder' => 'Choisir une entreprise',
                'label' => 'Entreprise',
            ])
            ;

        $profChoices = [];
        if (!empty($options['prof_choices'])) {
            $profChoices = array_combine($options['prof_choices'], $options['prof_choices']);
        }

        $builder
        ->add('profReferent', ChoiceType::class, [
            'choices' => $profChoices,
            'placeholder' => 'Choisir un professeur',
            'mapped' => true,
            'label' => 'Professeur référent',
        ])
        ->add('profVisite', ChoiceType::class, [
            'choices' => $profChoices,
            'placeholder' => 'Choisir un professeur',
            'mapped' => true,
            'label' => 'Professeur visite',
        ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
            'prof_choices' => [],
        ]);
    }
}
