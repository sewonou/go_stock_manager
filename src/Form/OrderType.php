<?php

namespace App\Form;

use App\Entity\Order;
use App\Entity\Supplier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            /*->add('status')*/
            /*->add('reference')*/
            ->add('supplier', EntityType::class, $this->getConfiguration("", "", [
                'class' => Supplier::class,
                'choice_label' => 'name',
                'placeholder' => "Choisir le fournisseur du produit.",
            ]))
            ->add('orderLines', CollectionType::class,$this->getConfiguration("", "",
                [
                    'entry_type' => OrderLineType::class,
                    'allow_add' => true,
                    'allow_delete' => true
                ])
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
