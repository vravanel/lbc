<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Faker\Factory as Faker;
use App\Entity\PersonalInfo;
use App\Enum\UserTypeEnum;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}
    public function load(ObjectManager $manager): void
    {

        $faker = Faker::create();

        for ($i = 1; $i <= 5; $i++) {
            $user = new User();
            $user->setEmail("user" . $i . "@test.com");
            $user->setPassword($this->passwordHasher->hashPassword($user, 'test'));
            $user->setUserType($faker->randomElement(UserTypeEnum::cases()));
            $user->setRoles(["ROLE_USER"]);
            $user->setPhone($i * 1000000000);
            $user->setUsername("pseudo " . $i);
            $user->setCreatedAt(new DateTimeImmutable());
            $this->addReference("user_" . $i, $user);
            $manager->persist($user);

            // Créer le profil utilisateur

            $profile = new PersonalInfo();
            $profile->setUser($user);  // Associe le profil à l'utilisateur
            $profile->setCivility($faker->randomElement(['Madame', 'Monsieur', 'Non précisé']));
            $profile->setLastname($faker->lastName);
            $profile->setFirstname($faker->firstName);
            $profile->setDateOfBirth($faker->dateTimeBetween('-65 years', '-18 years')->format('Y-m-d'));
            $manager->persist($profile);
        }

        $admin = new User();
        $admin->setEmail("admin@test.com");
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'test'));
        $admin->setRoles(["ROLE_ADMIN"]);
        $admin->setUserType($faker->randomElement(UserTypeEnum::cases()));
        $admin->setPhone('0555555555');
        $admin->setUsername("pseudo");
        $admin->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($admin);

        $manager->flush();
    }
}
