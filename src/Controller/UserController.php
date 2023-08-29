<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/users', name: 'user')]
    public function index(UserRepository $repository): Response
    {
        $data = $repository->findAll();
        return $this->render('user/index.html.twig', [
            'data' => $data,
        ]);
    }

    #[Route('/users/new', name: 'user_add')]
    public function add(EntityManagerInterface $manager, UserPasswordHasherInterface $encoder, Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);
            $this->addFlash('success', "L'utilisateur <strong>{$user->getFullName()}</strong> a bien été créer");
            $manager->persist($user);
            $manager->flush();
            return  $this->redirectToRoute('user');
        }

        return $this->render('user/new.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    #[Route('/users/{id}', name: 'user_edit')]
    public function edit(User $user, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder, Request $request): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);
            $this->addFlash('success', "L'utilisateur <strong>{$user->getFullName()}</strong> a bien été modifier");
            $manager->persist($user);
            $manager->flush();
            return  $this->redirectToRoute('user');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    #[Route('/users/{id}/delete', name: 'user_delete')]
    public function delete(User $user, EntityManagerInterface $manager):Response
    {
        $this->addFlash('success', "L'utilisateur <strong>{$user->getFullName()}</strong> a bien été supprimer");
        $manager->remove($user);
        $manager->flush();
        return $this->redirectToRoute('user');
    }



    #[Route('/users/{id}/view', name: 'user_show')]
    public function show(User $user):Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user
        ]);
    }
}
