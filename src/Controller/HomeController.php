<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\StatsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function index(StatsService $statsService): Response
    {
        $stats      = $statsService->getStats();
        dump($stats);
        return $this->render('home/index.html.twig', [
            'stats' => $stats,
        ]);
    }

}
