<?php

namespace App\Controller;

use App\Entity\Supplier;
use App\Form\SupplierType;
use App\Repository\SupplierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SupplierController extends AbstractController
{
    #[Route('/suppliers', name: 'supplier')]
    public function index(SupplierRepository $repository): Response
    {
        $data = $repository->findAll();
        return $this->render('supplier/index.html.twig', [
            'data' => $data,
        ]);
    }

    #[Route('/suppliers/new', name: 'supplier_add')]
    public function add(EntityManagerInterface $manager,Request $request):Response
    {
        $supplier = new Supplier();
        $form = $this->createForm(SupplierType::class, $supplier);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success', "Le fournisseur <strong>{$supplier->getName()}</strong> a bien été créer");
            $manager->persist($supplier);
            $manager->flush();
            return  $this->redirectToRoute('supplier');
        }
        return $this->render('supplier/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/suppliers/{id}', name: 'supplier_edit')]
    public function edit(Supplier $supplier, EntityManagerInterface $manager, Request $request):Response
    {
        $form = $this->createForm(SupplierType::class, $supplier);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success', "Le fournisseur <strong>{$supplier->getName()}</strong> a bien été créer");
            $manager->persist($supplier);
            $manager->flush();
            return  $this->redirectToRoute('supplier');
        }
        return  $this->render('supplier/edit.html.twig', [
            'form' => $form->createView(),
            'supplier' => $supplier,
        ]);
    }

    #[Route('/suppliers/{id}/delete', name: 'supplier_delete')]
    public function delete(Supplier $supplier, EntityManagerInterface $manager): Response
    {
        $this->addFlash('success', "Le fournisseur <strong>{$supplier->getName()}</strong> a bien été supprimer");
        $manager->remove($supplier);
        $manager->flush();
        return  $this->redirectToRoute('supplier');
    }

    #[Route('/suppliers/{id}/show', name: 'supplier_show')]
    public function view(Supplier $supplier):Response
    {
        return $this->render('supplier/show.html.twig', [
            'supplier' => $supplier,
        ]);
    }


}
