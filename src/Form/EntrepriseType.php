<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomEntreprise', null, [
                'label' => 'Nom de l\'entreprise',
                'attr' => ['placeholder' => 'Nom de l\'entreprise']
            ])
            ->add('adresseEntreprise', null, [
                'label' => 'Adresse',
                'attr' => ['placeholder' => 'Adresse']
            ])
            ->add('villeEntreprise', null, [
                'label' => 'Ville',
                'attr' => ['placeholder' => 'Ville']
            ])
            ->add('cpEntreprise', IntegerType::class, [
                'label' => 'Code postal',
                'attr' => ['placeholder' => 'Code postal'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un nombre.',
                    ]),
                ],
            ])
            ->add('tuteurEntreprise', null, [
                'label' => 'Tuteur',
                'attr' => ['placeholder' => 'Tuteur']
            ])
            ->add('telephoneEntreprise', TelType::class, [
                'label' => 'Téléphone',
                'attr' => ['placeholder' => 'Téléphone']
            ])
            ->add('mailEntreprise', EmailType::class, [
                'attr' => ['placeholder' => 'Adresse mail'],
                'constraints' => [
                    new Email(
                        message: 'Veuillez saisir une adresse e-mail valide.',
                    ),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
