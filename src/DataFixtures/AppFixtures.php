<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->encoder = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $roleAdmin = new Role();
        $roleAdmin->setTitle('ROLE_ADMIN')
            ->setDisplay('Manager')
        ;
        $roleUser = new Role();
        $roleUser->setTitle('ROLE_USER')
            ->setDisplay('Vendeur')
        ;

        $manager->persist($roleAdmin);
        $manager->persist($roleUser);
        $user = new User();
        $password = $this->encoder->hashPassword($user, 'admin1234');
        $user->setUsername('admin')
            ->setPassword($password)
            ->setFullName('Djanta Dev')
            ->setUserRole($roleAdmin)
            ->setDescription("Compte administrateur automatiquement créer")
            ->setAddress("Lomé, Togo : Gblinkomé, 43 Rue des amoureux")
            ->setPhone('+228 91 44 06 71')
        ;

        $manager->persist($user);
        $manager->flush();

    }
}
