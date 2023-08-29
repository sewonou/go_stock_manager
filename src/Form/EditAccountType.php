<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditAccountType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, $this->getConfiguration("Nom d'utilisateur", "Saisir le nom d'utilisateur"))
            ->add('fullName', TextType::class, $this->getConfiguration("Nom complet", "Saisir le nom complet"))
            ->add('imageFile', FileType::class, $this->getConfiguration("Image de profil", "Choisir l'image"))
            ->add('phone', TextType::class, $this->getConfiguration("Numéro de téléphone", "Saisir le nméro de téléphone"))
            ->add('address', TextType::class, $this->getConfiguration("Adresse complète", "Saisir l'adresse complète"))
            ->add('description', TextareaType::class, $this->getConfiguration("Description", "Saisir la description complète "))
            ->add('userRole', EntityType::class, $this->getConfiguration("", "", [
                'class' => Role::class,
                'choice_label' => 'display',
                'placeholder' => "Choisir le niveau d'accès ...",
            ]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
