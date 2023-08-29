<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, $this->getConfiguration("", ""))
            ->add('password', PasswordType::class , $this->getConfiguration("", ""))
            ->add('confirmPassword', PasswordType::class, $this->getConfiguration("", ""))
            ->add('fullName', TextType::class, $this->getConfiguration("", ""))
            ->add('imageFile',  FileType::class, $this->getConfiguration("", ""))
            ->add('phone', TextType::class, $this->getConfiguration("", ""))
            ->add('address', TextType::class, $this->getConfiguration("", ""))
            ->add('description', TextareaType::class, $this->getConfiguration("", ""))
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
