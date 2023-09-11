<?php

namespace App\Controller;

use App\Entity\OutInventory;
use App\Form\OutInventoryType;
use App\Repository\OutInventoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OutInventoryController extends AbstractController
{
    #[Route('/out/inventory', name: 'out_inventory')]
    public function index(OutInventoryRepository $repository): Response
    {
        $data = $repository->findBy([], ['createdAt' => 'DESC'], null, null);
        return $this->render('out_inventory/index.html.twig', [
            'data' => $data,
        ]);
    }

    #[Route('/out/inventory/add', name: 'out_inventory_add')]
    public function add(EntityManagerInterface $manager, Request $request, OutInventoryRepository $repository): Response
    {
        $outInventory = new OutInventory();
        $form = $this->createForm(OutInventoryType::class, $outInventory);
        $next = $repository->count([])+1 ;
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            foreach($outInventory->getOutInventoryLines() as $outInventoryLine) {
                $outInventoryLine->setInventory($outInventory);
                $manager->persist($outInventoryLine);
            }
            $outInventory->setAuthor($this->getUser())
                ->setReference('OUTSTOCK-'.$next)
            ;
            $manager->persist($outInventory);
            $manager->flush();

            $this->addFlash('success', "La sortie de stock de reférence <strong>{$outInventory->getReference()}</strong> est bien enregistrer");

            /*$session->clear();*/
            return $this->redirectToRoute('out_inventory');
        }
        return $this->render('out_inventory/new.html.twig', [
                'form' => $form->createView(),
        ]);
    }

    #[Route('/out/inventory/{id}', name: 'out_inventory_edit')]
    public function edit(EntityManagerInterface $manager, Request $request, OutInventory $outInventory): Response
    {
        $form = $this->createForm(OutInventoryType::class, $outInventory);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            foreach($outInventory->getOutInventoryLines() as $outInventoryLine) {
                $outInventoryLine->setInventory($outInventory);
                $manager->persist($outInventoryLine);
            }
            $outInventory->setAuthor($this->getUser());
            $manager->persist($outInventory);
            $manager->flush();

            $this->addFlash('success', "La sortie de stock de reférence <strong>{$outInventory->getReference()}</strong> est bien modifier");

            /*$session->clear();*/
            return $this->redirectToRoute('out_inventory');
        }
        return $this->render('out_inventory/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/out/inventory/{id}/delete', name: 'out_inventory_delete')]
    public function remove(EntityManagerInterface $manager, OutInventory $outInventory): Response
    {
        $this->addFlash('success', "L'inventaire de sortie <strong>{$outInventory->getReference()}</strong> a bien été supprimer");
        $manager->remove($outInventory);
        $manager->flush();
        return $this->redirectToRoute('out_inventory');
    }

    #[Route('/out/inventory/{id}/show', name: 'out_inventory_show')]
    public function show(OutInventory $outInventory): Response
    {
        return $this->render('out_inventory/show.html.twig', [
            'outInventory' => $outInventory,
        ]);
    }
}
