<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, $this->getConfiguration("",""))
            ->add('description', TextareaType::class, $this->getConfiguration("",""))
            ->add('imageFile', FileType::class, $this->getConfiguration("",""))
            ->add('brandName', TextType::class, $this->getConfiguration("",""))
            ->add('salePrice', IntegerType::class, $this->getConfiguration("",""))
            ->add('unit', TextType::class, $this->getConfiguration("",""))
            ->add('minQte', IntegerType::class, $this->getConfiguration("",""))
            ->add('initQte', IntegerType::class, $this->getConfiguration("",""))
            ->add('codeBar', TextType::class,  $this->getConfiguration("",""))
            ->add('category', EntityType::class, $this->getConfiguration("","", [
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => "Choisir la catégorie du produit.",
            ]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
