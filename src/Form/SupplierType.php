<?php

namespace App\Form;

use App\Entity\Supplier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupplierType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, $this->getConfiguration("Nom du fournisseur", "Saisir le nom du fournisseur"))
            ->add('contact', TextType::class, $this->getConfiguration("Nom de la personne contact", "Saisir le nom de la personne contact"))
            ->add('email', EmailType::class, $this->getConfiguration("Adresse Email", "Saisir l'adresse email de l'entreprise"))
            ->add('phone', TextType::class, $this->getConfiguration("Numéro de téléphone","Saisir le numéro de téléphone"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Supplier::class,
        ]);
    }
}
