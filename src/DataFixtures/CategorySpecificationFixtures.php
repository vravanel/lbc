<?php

namespace App\DataFixtures;

use App\Entity\CategorySpecification;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CategorySpecificationFixtures extends Fixture implements DependentFixtureInterface
{
    public const SPECIFICATIONS = [
        'Voitures' => [
            ['name' => 'Marque'],
            ['name' => 'Modèle'],
            ['name' => 'Kilométrage'],
        ],
        'Motos' => [
            ['name' => 'Cylindrée'],
            ['name' => 'Marque'],
        ],
        'Caravaning' => [
            ['name' => 'Longueur'],
            ['name' => 'Nombre de couchages'],
        ],
        'Ventes immobilières' => [
            ['name' => 'Type de bien'],
            ['name' => 'Surface habitable'],
            ['name' => 'Nombre de pièces'],
        ],
        'Locations' => [
            ['name' => 'Type de bien'],
            ['name' => 'Surface habitable'],
            ['name' => 'Ce bien est'],
            ['name' => 'Nombre de pièces']
        ],
        'Informatique' => [
            ['name' => 'Processeur'],
            ['name' => 'Mémoire vive (RAM)'],
        ],
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::SPECIFICATIONS as $subCategoryName => $specifications) {
            foreach ($specifications as $specificationData) {
                $specification = new CategorySpecification();
                $specification->setName($specificationData['name']);
                $specification->setRequired(rand(0, 1));
                $specification->setSubCategory($this->getReference($subCategoryName));
                $manager->persist($specification);
                $this->addReference($subCategoryName . '_' . $specificationData['name'], $specification);
            }
        }

        $manager->flush();
    }


    public function getDependencies()
    {
        return [
            SubCategoryFixtures::class,
        ];
    }
}
