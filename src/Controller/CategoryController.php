<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/categories', name: 'category')]
    public function index(CategoryRepository $repository): Response
    {
        $data = $repository->findBy([], ['createdAt' => 'DESC'], null, null);
        return $this->render('category/index.html.twig', [
            'data' => $data,
        ]);
    }

    #[Route('/categories/new', name: 'category_add')]
    public function new(EntityManagerInterface $manager, Request $request):Response
    {

        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success', "La catégorie <strong>{$category->getName()}</strong> a bien été ajouter");
            $manager->persist($category);
            $manager->flush();
            return $this->redirectToRoute('category_add');
        }
        return $this->render('category/new.html.twig', [
            'form' => $form->createView(),

        ]);
    }

    #[Route('/categories/{id}', name: 'category_edit')]
    public function edit(Category $category, EntityManagerInterface $manager, Request $request):Response
    {

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success', "La catégorie <strong>{$category->getName()}</strong> a bien été modifier");
            $manager->persist($category);
            $manager->flush();
            return $this->redirectToRoute('category');
        }
        return  $this->render('category/edit.html.twig', [
            'form' => $form->createView(),
            'category' => $category,
        ]);
    }

    #[Route('/categories/{id}/delete', name: 'category_delete')]
    public function remove(Category $category, EntityManagerInterface $manager): Response
    {
        $this->addFlash('success', "La catégorie <strong>{$category->getName()}</strong> a bien été supprimer");
        $manager->remove($category);
        $manager->flush();
        return  $this->redirectToRoute('category');
    }


    #[Route('/category/{id}/show', name: 'category_show')]
    public function view(Category $category):Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }
}
