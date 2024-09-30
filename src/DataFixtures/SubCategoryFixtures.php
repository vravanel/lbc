<?php

namespace App\DataFixtures;

use App\Entity\SubCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SubCategoryFixtures extends Fixture implements DependentFixtureInterface
{
    public const SUBCATEGORIES = [
        'Véhicules' => ['Voitures', 'Motos', 'Caravaning'],
        'Immobilier' => ['Ventes immobilières', 'Locations'],
        'Multimédia' => ['Informatique', 'Consoles & Jeux vidéo', 'Image & Son', 'Téléphonie'],
        'Maison' => ['Ameublement', 'Électroménager'],
        'Mode' => ['Vêtements', 'Chaussures'],
        'Loisirs' => ['CD / Musique', 'Livres', 'Sports & Hobbies', 'Jeux & Jouets'],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::SUBCATEGORIES as $categoryName => $subCategories) {
            foreach ($subCategories as $subCategoryName) {
                $subCategory = new SubCategory();
                $subCategory->setName($subCategoryName);
                $subCategory->setCategory($this->getReference($categoryName));
                $this->addReference($subCategoryName, $subCategory);
                $manager->persist($subCategory);
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class
        ];
    }
}
