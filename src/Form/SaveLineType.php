<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\SaveLine;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SaveLineType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codeBar', TextType::class, [
                'label' => '',
                'attr' => [
                    'placeholder' => "",
                ]
            ])
            /*->add('product', EntityType::class, $this->getConfiguration("", "", [
                'class' => Product::class,
                'choice_label' => 'name',
                'placeholder' => "Choisir le produit.",
            ]))*/
           /* ->add('salePrice', IntegerType::class, $this->getConfiguration("", ""))
            ->add('stockQte', IntegerType::class, $this->getConfiguration("", ""))*/
            ->add('qte', IntegerType::class, [
                'label' => '',
                'attr' => [
                    'placeholder' => "",
                ]
            ])
        ;
        $builder->get('codeBar')->addEventListener(
            FormEvents::POST_SUBMIT,
                function (FormEvent $event){
                    $form = $event->getForm();
                    $codeBar = $event->getForm()->getData(['codeBar']);
                    if ($codeBar) {
                        // Recherchez le produit en fonction du codeBar
                        $product = $this->entityManager
                            ->getRepository(Product::class)
                            ->findOneBy(['codeBar' => $codeBar]);
                        if($product){
                            $this->addProductField($form->getParent(), $product);
                            $this->addStockQteField($form->getParent(), $product);
                            $this->addSalePriceField($form->getParent(), $product);
                        }
                    }
                }
            );
        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event){
                $data = $event->getData();
                $product = $data->getProduct();
                $form = $event->getForm();
               if($product){
                   $this->addProductField($form, $product);
                   $this->addStockQteField($form, $product);
                   $this->addSalePriceField($form, $product);
               }else{
                   $this->addProductField($form, null);
                   $this->addStockQteField($form, null);
                   $this->addSalePriceField($form, null);
               }
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([

        ]);
    }

    public function addProductField(FormInterface $form, ?Product $product)
    {

            $form->add('product', TextType::class,[
                'data' => ($product)? $product->getName(): '',
                'label' => '',
                'attr' => [
                    'placeholder' => "",
                    'disabled' => true,
                ]
            ]);

    }

    public function  addSalePriceField(FormInterface $form, ?Product $product)
    {

            $form->add('salePrice', IntegerType::class, [
                'data' => ($product)? $product->getSalePrice(): 0,
                'label' => '',
                'attr' => [
                    'placeholder' => "",
                    'disabled' => true,
                ]
            ]);
    }

    public function addStockQteField(FormInterface $form, ?Product $product)
    {

            $form->add('stockQte', IntegerType::class, [
                'data' => ($product)? $product->getInitQte(): 0,
                'label' => '',
                'attr' => [
                    'placeholder' => "",
                    'disabled' => true,
                ]
            ]);
    }
}
