<?php

namespace App\Controller;


use App\Entity\ChangePassword;
use App\Form\ChangePasswordType;
use App\Form\EditAccountType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'account')]
    public function index(): Response
    {
        $user = $this->getUser();
        return $this->render('account/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/login', name: 'account_login')]
    public function login(AuthenticationUtils $utils): Response
    {
        $errors  = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();
        return $this->render('account/login.html.twig', [
            'username' => $username,
            'hasError' => $errors !== null,
        ]);
    }

    #[Route('/logout', name: 'account_logout')]
    public function logout(): void
    {

    }

    #[Route('/account/change_password', name: 'account_change_password')]
    public function changePassword(EntityManagerInterface $manager, UserPasswordHasherInterface $encoder, Request $request): Response
    {
        $changePassword = new ChangePassword();
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $changePassword);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            if (!password_verify($changePassword->getOldPassword(), $user->getPassword())) {
                $form->get('oldPassword')->addError(new FormError("Le mot de passe que vous avez taper n'est pas votre mot de passe actuel !"));

            } else {

                $newPassword = $changePassword->getNewPassword();
                $hash = $encoder->hashPassword($user, $newPassword);
                $user->setPassword($hash);
                $manager->persist($user);
                $manager->flush();
                $this->addFlash(
                    'success',
                    "Votre mot de passe a bien été modifier."
                );
                return $this->redirectToRoute('account');
            }
        }

        return $this->render('account/change_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/account/change_profile', name: 'account_change_profile')]
    public function editAccount(EntityManagerInterface $manager, Request $request): Response
    {
        $user = $this->getUser();
        //$username = $user->getUserName();
        $form = $this->createForm(EditAccountType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //$user->setUsername($username);

            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', "Votre profil a bien été mise à jour");
            return  $this->redirectToRoute('account');
        }
        return $this->render('account/editAccount.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}
