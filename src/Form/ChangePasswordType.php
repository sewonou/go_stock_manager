<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('oldPassword', PasswordType::class, $this->getConfiguration("Ancien mot de passe", "Saisir l'ancien mot de passe"))
            ->add('newPassword', PasswordType::class, $this->getConfiguration("Nouveau mot de passe", "Saisir le nouveau mot de passe"))
            ->add('confirmPassword', PasswordType::class, $this->getConfiguration("Confirmer mot de passe", "Confirmer le nouveau mot de passe"))

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
