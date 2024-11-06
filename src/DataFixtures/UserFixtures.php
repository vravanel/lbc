<?php

namespace App\DataFixtures;

use App\Entity\User;
use Faker\Factory as Faker;
use App\Entity\UserProfile;
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
            $user->setRoles(["ROLE_USER"]);
            $user->setFirtname("user " . $i);
            $user->setLastname("user " . $i);
            $user->setUsername("pseudo " . $i);
            $this->addReference("user_" . $i, $user);
            $manager->persist($user);

            // Créer le profil utilisateur
            $profile = new UserProfile();
            $profile->setUser($user);  // Associe le profil à l'utilisateur
            $profile->setCivility($faker->randomElement(['Madame', 'Monsieur', 'Non précisé']));
            $profile->setLastname($faker->lastName);
            $profile->setFirstname($faker->firstName);
            $profile->setBirthdate($faker->dateTimeBetween('-60 years', '-18 years')); // Entre 18 et 60 ans
            $profile->setAdress($faker->address);
            $profile->setMail($faker->email); // Pour ajouter un email différent si nécessaire
            $profile->setCategorySocioprofessionnal($faker->randomElement(['Cadre', 'Employé', 'Ouvrier', 'Indépendant']));

            $manager->persist($profile);
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
