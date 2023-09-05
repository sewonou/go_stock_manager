<?php

namespace App\Controller;

use App\Entity\Sale;
use App\Entity\SaleLine;
use App\Form\SaleType;
use App\Repository\ProductRepository;
use App\Repository\SaleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\Form\remove;

class SaleController extends AbstractController
{
    #[Route('/sales', name: 'sale')]
    public function index(SaleRepository $repository, SessionInterface $session): Response
    {
        $session->clear();
        $data = $repository->findAll();
        return $this->render('sale/index.html.twig', [
            'data' => $data,
        ]);
    }


    #[Route('/sales/get_product', name: 'get_line')]
    public function get_line(Request $request, ProductRepository $repository): JsonResponse
    {
        $codeBarValue = $request->request->get('code_bar_value', '');
        $product = $repository->findOneBy(['codeBar'=>$codeBarValue]);
        if ($product) {
            // Convertir l'objet Product en tableau associatif
            $productData = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getSalePrice(),
                // Ajoutez d'autres propriétés ici
            ];

            // Retourner les données du produit au format JSON
            return $this->json(['data' => $productData]);
        } else {
            return $this->json(['error' => 'Produit non trouvé'], 404);
        }

        //return $this->json(['data' => $product]);

    }


    #[Route('/sales/new', name: 'sale_add')]
    public function saveSales(Request $request, EntityManagerInterface $manager, SaleRepository $repository) : Response
    {
        $sale = new Sale();
        $form = $this->createForm(SaleType::class, $sale);
        $total = $repository->count([]);
        $next = $total +1;
        //dd($total);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            foreach($sale->getSaleLines() as $saleLine) {
                $saleLine->setSale($sale);
                $manager->persist($saleLine);
            }
            $sale->setAuthor($this->getUser())
                ->setReference('VNT-'.$next);
            $manager->persist($sale);
            $manager->flush();

            $this->addFlash('success', "La vente <strong>{$sale->getReference()}</strong> est bien enregistrer");

            /*$session->clear();*/
            return $this->redirectToRoute('sale');

        }

        return $this->render('sale/new.html.twig', [
            /*'formSaveLine' => $formSaveLine->createView(),*/
            'form' => $form->createView(),

        ]);
    }

    #[Route('/sales/{id}', name: 'sale_edit')]
    public function edit(Sale $sale, Request $request, EntityManagerInterface $manager)
    {
        $saleLine = new SaleLine();
        $form = $this->createForm(SaleType::class, $sale);
        $sale->addSaleLine($saleLine);



        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            foreach($sale->getSaleLines() as $saleLine) {
                $saleLine->setSale($sale);
                $manager->persist($saleLine);
            }
            $sale->setAuthor($this->getUser());
            $manager->persist($sale);
            $manager->flush();

            $this->addFlash('success', "La vente <strong>{$sale->getReference()}</strong> est bien modifer");

            /*$session->clear();*/
            return $this->redirectToRoute('sale');

        }

        return $this->render('sale/edit.html.twig', [
            /*'formSaveLine' => $formSaveLine->createView(),*/
            'form' => $form->createView(),

        ]);
    }

    #[Route('/sales/{id}/delete', name: 'sale_delete')]
    public function delete(Sale $sale, EntityManagerInterface $manager)
    {
        $this->addFlash('success', "La vente <strong>{$sale->getReference()}</strong> a bien été supprimé");
        $manager->remove($sale);
        $manager->flush();
        return $this->redirectToRoute('sale');

    }

    #[Route('/sales/{id}/show', name: 'sale_show')]
    public function show(Sale $sale)
    {

        return $this->render('sale/show.html.twig', [
            'sale' => $sale
        ]);

    }



}
