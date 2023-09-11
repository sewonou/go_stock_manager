<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StockController extends AbstractController
{
    #[Route('/stock', name: 'stock')]
    public function index(ProductRepository $repository): Response
    {
        $data = $repository->findBy([], ['createdAt' => 'DESC'], null, null);
        $sum = array_reduce($data, function ($total, $product){
            return $total + ($product->getStockValue());
        }, 0);

        return $this->render('stock/index.html.twig', [
            'data' => $data,
            'StockValue' =>  $sum,
        ]);
    }
}
