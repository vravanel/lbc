<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $user = new User();
            $user->setEmail("user" . $i . "@test.com");
            $user->setPassword($this->passwordHasher->hashPassword($user, 'test'));
            $user->setRoles(["ROLE_USER"]);
            $user->setFirtname("user " . $i);
            $user->setLastname("user " . $i);
            $user->setUsername("pseudo " . $i);
            $this->addReference("user_" . $i, $user);
            $manager->persist($user);
        }

        $admin = new User();
        $admin->setEmail("admin@test.com");
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'test'));
        $admin->setRoles(["ROLE_ADMIN"]);
        $admin->setFirtname("admin");
        $admin->setLastname("admin");
        $admin->setUsername("pseudo");
        $manager->persist($admin);

        $manager->flush();
    }
}
