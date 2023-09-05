<?php

namespace App\Form;

use App\Entity\Sale;
use App\Entity\SaleLine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SaleType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            /*->add('reference', TextType::class, $this->getConfiguration('Référence',''))*/
            ->add('clientName', TextType::class, $this->getConfiguration('Nom du client',''))
            ->add('saleLines', CollectionType::class,$this->getConfiguration("", "",
                [
                'entry_type' => SaleLineType::class,
                'allow_add' => true,
                'allow_delete' => true
                ])
            )

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sale::class,
        ]);
    }
}
