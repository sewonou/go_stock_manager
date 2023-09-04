<?php


namespace App\Service;


use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class StatsService
{

    private $manager;
    private $productRepository;

    public function __construct(EntityManagerInterface $manager, ProductRepository $productRepository)
    {
        $this->manager = $manager;
        $this->productRepository = $productRepository;
    }

    public function getStats()
    {
        $productOutOfStock = $this->getProductOutOfStock();
        return compact('productOutOfStock');
    }

    public function getProductOutOfStock()
    {
        $products = $this->productRepository->findAll();
        $productsOutOfStock = [];
        foreach ($products as $product){
            if($product->getStockQte() < $product->getInitQte()){
                $productsOutOfStock[] = $product;
            }
        }

        return $productsOutOfStock;
    }

}
