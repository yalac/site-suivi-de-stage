<?php

namespace App\Form;

use App\Entity\Eleve;
use App\Entity\Option;
use App\Entity\Promotion;
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
            ->add('optionEleve', EntityType::class, [
                'class' => Option::class,
                'choice_label' => static fn (Option $option): string => (string) $option,
                'label' => 'Option',
                'placeholder' => 'Sélectionner une option',
            ])
            ->add('promotionEleve', EntityType::class, [
                'class' => Promotion::class,
                'choice_label' => static fn (Promotion $promotion): string => (string) $promotion,
                'label' => 'Promotion',
                'placeholder' => 'Sélectionner une promotion',
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
