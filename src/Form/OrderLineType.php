<?php

namespace App\Form;

use App\Entity\OrderLine;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderLineType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codeBar', TextType::class, $this->getConfiguration("", "", [
                'mapped'=>false
            ]))
            ->add('product', EntityType::class, $this->getConfiguration("", "", [
                'class' => Product::class,
                'choice_label' => 'name',
                'placeholder' => "Le Produit...",
            ]))
            ->add('purchasePrice', TextType::class, $this->getConfiguration("", ""))
            ->add('qte', IntegerType::class, $this->getConfiguration("", ""))
            ->add('amount', TextType::class, $this->getConfiguration("", "", [
                'mapped'=>false
            ]))

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrderLine::class,
        ]);
    }
}
