<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'order')]
    public function index(OrderRepository $repository): Response
    {
        $data = $repository->findAll();
        return $this->render('order/index.html.twig', [
            'data' => $data,
        ]);
    }

    #[Route('/order/add', name: 'order_add')]
    public function add(EntityManagerInterface $manager, Request $request): Response
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            foreach($order->getOrderLines() as $orderLine) {
                $orderLine->setPurchase($order);
                $manager->persist($orderLine);
            }
            $order->setAuthor($this->getUser());
            $manager->persist($order);
            $manager->flush();

            $this->addFlash('success', "La commande de reférence <strong>{$order->getReference()}</strong> est bien enregistrer");

            /*$session->clear();*/
            return $this->redirectToRoute('order');
        }
        return $this->render('order/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/order/{id}', name: 'order_edit')]
    public function edit(EntityManagerInterface $manager, Request $request, Order $order): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            foreach($order->getOrderLines() as $orderLine) {
                $orderLine->setOrder($order);
                $manager->persist($orderLine);
            }
            $order->setAuthor($this->getUser());
            $manager->persist($order);
            $manager->flush();

            $this->addFlash('success', "La commande de reférence <strong>{$order->getReference()}</strong> est bien modifier");

            /*$session->clear();*/
            return $this->redirectToRoute('order');
        }
        return $this->render('order/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/order/{id}/delete', name: 'order_delete')]
    public function remove(EntityManagerInterface $manager, Order $order): Response
    {
        $this->addFlash('success', "L'inventaire de sortie <strong>{$order->getReference()}</strong> a bien été supprimer");
        $manager->remove($order);
        $manager->flush();
        return $this->redirectToRoute('order');
    }

    #[Route('/order/{id}/show', name: 'order_show')]
    public function show(Order $order): Response
    {
        return $this->render('order/show.html.twig', [
            'order' => $order,
        ]);
    }
}
