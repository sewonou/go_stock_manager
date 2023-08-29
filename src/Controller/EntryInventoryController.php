<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntryInventoryController extends AbstractController
{
    #[Route('/entry/inventory', name: 'app_entry_inventory')]
    public function index(): Response
    {
        return $this->render('entry_inventory/index.html.twig', [
            'controller_name' => 'EntryInventoryController',
        ]);
    }
}
