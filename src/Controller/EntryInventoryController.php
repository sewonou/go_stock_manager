<?php

namespace App\Controller;

use App\Entity\EntryInventory;
use App\Form\EntryInventoryType;
use App\Repository\EntryInventoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntryInventoryController extends AbstractController
{
    #[Route('/entry/inventory', name: 'entry_inventory')]
    public function index(EntryInventoryRepository $repository): Response
    {
        $data = $repository->findAll();
        return $this->render('entry_inventory/index.html.twig', [
            'data' => $data,
        ]);
    }

    #[Route('/entry/inventory/add', name: 'entry_inventory_add')]
    public function add(EntityManagerInterface $manager, Request $request, EntryInventoryRepository $repository): Response
    {
        $entryInventory = new EntryInventory();
        $form = $this->createForm(EntryInventoryType::class, $entryInventory);
        $form->handleRequest($request);
        $next = $repository->count([])+1;
        if($form->isSubmitted() && $form->isValid()){
            foreach($entryInventory->getEntryInventoryLines() as $entryInventoryLine) {
                $entryInventoryLine->setInventory($entryInventory);
                $manager->persist($entryInventoryLine);
            }
            $entryInventory->setAuthor($this->getUser())
                ->setReference('INSTOCK-'.$next)
            ;
            $manager->persist($entryInventory);
            $manager->flush();

            $this->addFlash('success', "L'entrée de stock de reférence <strong>{$entryInventory->getReference()}</strong> est bien enregistrer");

            /*$session->clear();*/
            return $this->redirectToRoute('entry_inventory');
        }
        return $this->render('entry_inventory/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/entry/inventory/{id}', name: 'entry_inventory_edit')]
    public function edit(EntityManagerInterface $manager, Request $request, EntryInventory $entryInventory): Response
    {
        $form = $this->createForm(EntryInventoryType::class, $entryInventory);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            foreach($entryInventory->getEntryInventoryLines() as $entryInventoryLine) {
                $entryInventoryLine->setInventory($entryInventory);
                $manager->persist($entryInventoryLine);
            }
            $entryInventory->setAuthor($this->getUser());
            $manager->persist($entryInventory);
            $manager->flush();

            $this->addFlash('success', "L'entrée de stock de reférence <strong>{$entryInventory->getReference()}</strong> est bien modifier");

            /*$session->clear();*/
            return $this->redirectToRoute('entry_inventory');
        }
        return $this->render('entry_inventory/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/entry/inventory/{id}/delete', name: 'entry_inventory_delete')]
    public function remove(EntityManagerInterface $manager, EntryInventory $entryInventory): Response
    {
        $this->addFlash('success', "L'inventaire de sortie <strong>{$entryInventory->getReference()}</strong> a bien été supprimer");
        $manager->remove($entryInventory);
        $manager->flush();
        return $this->redirectToRoute('entry_inventory');
    }

    #[Route('/entry/inventory/{id}/show', name: 'entry_inventory_show')]
    public function show(EntryInventory $entryInventory): Response
    {
        return $this->render('entry_inventory/show.html.twig', [
            'entryInventory' => $entryInventory,
        ]);
    }
}
