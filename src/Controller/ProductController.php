<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'product')]
    public function index(ProductRepository $repository): Response
    {
        $data = $repository->findAll();
        return $this->render('product/index.html.twig', [
            'data' => $data,
        ]);
    }

    #[Route('/products/new', name: 'product_add')]
    public function add(EntityManagerInterface $manager, Request $request):Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $product->setAuthor($this->getUser());
            $this->addFlash('success', "Le produit <strong>{$product->getName()}</strong> à bien été ajouter");
            $manager->persist($product);
            $manager->flush();
            return $this->redirectToRoute('product');
        }
        return $this->render('product/new.html.twig', [
            'form' => $form->createView(),
            'product' => $product,
        ]);
    }

    #[Route('/products/{id}', name: 'product_edit')]
    public function edit(Product $product, EntityManagerInterface $manager, Request $request):Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $product->setAuthor($this->getUser());
            $this->addFlash('success', "Le produit <strong>{$product->getName()}</strong> à bien été ajouter");
            $manager->persist($product);
            $manager->flush();
            return $this->redirectToRoute('product');
        }
        return  $this->render('product/edit.html.twig', [
            'form' => $form->createView(),
            'product' => $product,
        ]);
    }

    #[Route('/products/{id}/delete', name: 'product_delete')]
    public function remove(Product $product, EntityManagerInterface $manager): Response
    {
        $this->addFlash('success', "Le produit <strong>{$product->getName()}</strong> à bien été ajouter");
        $manager->remove($product);
        $manager->flush();
        return  $this->redirectToRoute('product');
    }

    #[Route('/products/{id}/show', name: 'product_show')]
    public function view(Product $product):Response
    {

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }
}
