<?php

namespace App\DataFixtures;

use App\Entity\SubCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SubCategoryFixtures extends Fixture implements DependentFixtureInterface
{
    public const SUBCATEGORIES = [
        'Véhicules' => ['Voitures', 'Motos', 'Utilitaires', 'Camions', 'Caravaning'],
        'Immobilier' => ['Ventes immobilières', 'Locations', 'Colocations'],
        'Multimédia' => ['Informatique', 'Consoles & Jeux vidéo', 'Image & Son', 'Téléphonie'],
        'Maison' => ['Ameublement', 'Électroménager', 'Arts de la table', 'Décoration', 'Linge de maison', 'Bricolage', 'Jardinage'],
        'Mode' => ['Vêtements', 'Chaussures', 'Montres & Bijoux'],
        'Loisirs' => ['DVD / Films', 'CD / Musique', 'Livres', 'Animaux', 'Vélos', 'Sports & Hobbies', 'Instruments de musique', 'Jeux & Jouets'],
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
