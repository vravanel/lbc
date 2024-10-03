<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory as Faker;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AdFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create();

        foreach (SubCategoryFixtures::SUBCATEGORIES as $categoryName => $subCategories) {
            foreach ($subCategories as $subCategoryName) {
                for ($i = 0; $i < 10; $i++) {
                    $ad = new Ad();
                    $ad->setTitle($faker->sentence(3))
                        ->setDescription($faker->paragraph())
                        ->setPrice($faker->randomFloat(2, 10, 1000))
                        ->setCreateAt($faker->dateTimeInInterval('-1 year', 'now'))
                        ->setCity($faker->city())
                        ->setZipCode(rand('00000', '99999'))
                        ->setSubCategory($this->getReference($subCategoryName))
                        ->setUser($this->getReference("user_" . rand(1, 5)));
                    $this->addReference($subCategoryName . $i, $ad);
                    $manager->persist($ad);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SubCategoryFixtures::class
        ];
    }
}
