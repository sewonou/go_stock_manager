<?php

namespace App\Controller;

use App\Entity\Expense;
use App\Form\ExpenseType;
use App\Repository\ExpenseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExpenseController extends AbstractController
{
    #[Route('/expenses', name: 'expense')]
    public function index(ExpenseRepository $repository): Response
    {
        $data = $repository->findBy([], ['createdAt' => 'DESC'], null, null);
        return $this->render('expense/index.html.twig', [
            'data' => $data
        ]);
    }


    #[Route('/expenses/new', name: 'expense_add')]
    public function new(EntityManagerInterface $manager, Request $request):Response
    {

        $expense = new Expense();
        $form = $this->createForm(ExpenseType::class, $expense);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $expense->setAuthor($this->getUser());
            $this->addFlash('success', "La Dépense <strong>{$expense->getReference()}</strong> a bien été ajouter");
            $manager->persist($expense);
            $manager->flush();
            return $this->redirectToRoute('expense_add');
        }
        return $this->render('expense/new.html.twig', [
            'form' => $form->createView(),

        ]);
    }

    #[Route('/expenses/{id}', name: 'expense_edit')]
    public function edit(Expense $expense, EntityManagerInterface $manager, Request $request):Response
    {

        $form = $this->createForm(ExpenseType::class, $expense);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $expense->setAuthor($this->getUser());
            $this->addFlash('success', "La Dépense <strong>{$expense->getReference()}</strong> a bien été modifier");
            $manager->persist($expense);
            $manager->flush();
            return $this->redirectToRoute('expense');
        }
        return  $this->render('expense/edit.html.twig', [
            'form' => $form->createView(),
            'expense' => $expense,
        ]);
    }

    #[Route('/expenses/{id}/delete', name: 'expense_delete')]
    public function remove(Expense $expense, EntityManagerInterface $manager): Response
    {
        $this->addFlash('success', "La Dépense <strong>{$expense->getReference()}</strong> a bien été supprimer");
        $manager->remove($expense);
        $manager->flush();
        return  $this->redirectToRoute('expense');
    }


    #[Route('/expenses/{id}/show', name: 'expense_show')]
    public function view(Expense $expense):Response
    {
        return $this->render('category/show.html.twig', [
            'expense' => $expense,
        ]);
    }
}
