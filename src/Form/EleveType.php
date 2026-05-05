<?php

namespace App\Form;

use App\Entity\Eleve;
use App\Entity\Option;
use App\Entity\Promotion;
use App\Entity\Stage;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EleveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomEleve', null, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Nom de l\'élève']
            ])
            ->add('prenomEleve', null, [
                'label' => 'Prénom',
                'attr' => ['placeholder' => 'Prénom de l\'élève']
            ])
            ->add('profReferent', null, [
                'label' => 'Professeur référent',
                'attr' => ['placeholder' => 'Nom du professeur référent']
            ])
            ->add('profVisite', null, [
                'label' => 'Professeur de visite',
                'attr' => ['placeholder' => 'Nom du professeur de visite']
            ])
            ->add('optionEleve', EntityType::class, [
                'class' => Option::class,
                'choice_label' => function (Option $option) { return (string) $option; },
                'label' => 'Option',
                'placeholder' => 'Sélectionner une option'
            ])
            ->add('promotionEleve', EntityType::class, [
                'class' => Promotion::class,
                'choice_label' => function (Promotion $promotion) { return (string) $promotion; },
                'label' => 'Promotion',
                'placeholder' => 'Sélectionner une promotion'
            ])
            ->add('utilisateurs', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => function (Utilisateur $utilisateur) { return (string) $utilisateur; },
                'label' => 'Utilisateurs (Professeurs)',
                'multiple' => true,
                'attr' => ['class' => 'select-multiple']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Eleve::class,
        ]);
    }
}
