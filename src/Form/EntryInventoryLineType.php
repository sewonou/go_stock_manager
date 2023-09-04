<?php

namespace App\Form;

use App\Entity\EntryInventoryLine;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntryInventoryLineType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('qte', IntegerType::class, $this->getConfiguration("", ""))
            ->add('codeBar', TextType::class, $this->getConfiguration("", "", [
                'mapped' => false
            ]))
            ->add('product', EntityType::class, $this->getConfiguration("", "", [
                'class' => Product::class,
                'choice_label' => 'name',
                'placeholder' => "Le Produit...",
            ]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EntryInventoryLine::class,
        ]);
    }
}
