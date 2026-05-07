<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomUtilisateur')
            ->add('prenomUtilisateur')
            ->add('emailUtilisateur', EmailType::class, [
                'constraints' => [
                    new Email(
                        message: 'Veuillez saisir une adresse e-mail valide.',
                    ),
                ],
            ])
            ->add('mdpUtilisateur', PasswordType::class, [
                'label' => 'Mot de passe',
                'mapped' => false,
                'hash_property_path' => 'mdpUtilisateur',
                'constraints' => [
                    new NotBlank(
                        message: 'Entrez un mot de passe',
                    ),
                ],
            ])
            ->add('roleUtilisateur', EntityType::class, [
                'class' => Role::class,
                'choice_label' => function (Role $role) { return (string) $role->getNomRole(); },
                'label' => 'Rôle',
                'placeholder' => 'Sélectionner un rôle'
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
