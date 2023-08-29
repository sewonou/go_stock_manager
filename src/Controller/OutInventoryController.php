<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OutInventoryController extends AbstractController
{
    #[Route('/out/inventory', name: 'app_out_inventory')]
    public function index(): Response
    {
        return $this->render('out_inventory/index.html.twig', [
            'controller_name' => 'OutInventoryController',
        ]);
    }
}
