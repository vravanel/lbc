<?php

namespace App\DataFixtures;

use App\Entity\AdSpecification;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;

class AdSpecificationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create();

        foreach (SubCategoryFixtures::SUBCATEGORIES as $categoryName => $subCategories) {
            foreach ($subCategories as $subCategoryName) {
                for ($i = 0; $i < 10; $i++) {
                    $ad = $this->getReference($subCategoryName . $i);

                    $specTypes = $ad->getSubCategory()->getSpecificationTypes();

                    foreach ($specTypes as $specType) {
                        $adSpec = new AdSpecification();
                        $adSpec->setAd($ad);
                        $adSpec->setSpecificationType($specType);

                        switch ($specType->getType()) {
                            case 'select':
                                $options = $specType->getOptions();
                                $value = $faker->randomElement($options);
                                break;

                            case 'number':
                                if (strtolower($specType->getName()) === 'kilométrage') {
                                    $value = (string) $faker->numberBetween(5000, 200000);
                                } elseif (strtolower($specType->getName()) === 'surface habitable') {
                                    $value = (string) $faker->numberBetween(20, 200);
                                } elseif (strtolower($specType->getName()) === 'nombre de pièces') {
                                    $value = (string) $faker->numberBetween(1, 10);
                                } else {
                                    $value = (string) $faker->numberBetween(1, 1000);
                                }
                                break;

                            case 'text':
                            default:
                                $value = $faker->word();
                                break;
                        }

                        $adSpec->setValue($value);
                        $manager->persist($adSpec);
                    }
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AdFixtures::class,
            CategorySpecificationFixtures::class,
        ];
    }
}
