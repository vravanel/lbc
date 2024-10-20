<?php

namespace App\DataFixtures;

use App\Entity\SpecificationType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CategorySpecificationFixtures extends Fixture implements DependentFixtureInterface
{
    public const SPECIFICATIONS = [
        'Voitures' => [
            ['name' => 'Marque', 'type' => 'select', 'options' => ['Toyota', 'Peugeot', 'Citroën', 'Renault']],
            ['name' => 'Modele', 'type' => 'text'],
            ['name' => 'Kilometrage', 'type' => 'number'],
            ['name' => 'Carburant', 'type' => 'select', 'options' => ['essence', 'diesel', 'electrique', 'hybridre']],
            ['name' => 'Transmission', 'type' => 'select', 'options' => ['automatique', 'manualle', 'semi-automatique']],
            ['name' => 'Couleur', 'type' => 'text'],
        ],
        'Motos' => [
            ['name' => 'Cylindree', 'type' => 'number'],
            ['name' => 'Marque_Moto', 'type' => 'select', 'options' => ['Honda', 'Yamaha', 'Suzuki', 'Kawasaki']],
        ],
        'Caravaning' => [
            ['name' => 'Longueur', 'type' => 'number'],
            ['name' => 'Nombre_de_couchages', 'type' => 'number'],
        ],
        'Ventes immobilières' => [
            ['name' => 'Type_de_bien_vente', 'type' => 'select', 'options' => ['Appartement', 'Maison']],
            ['name' => 'Surface_habitable_vente', 'type' => 'number'],
            ['name' => 'Nombre_de_pieces_vente', 'type' => 'number'],
        ],
        'Locations' => [
            ['name' => 'Type_de_bien', 'type' => 'select', 'options' => ['Appartement', 'Maison']],
            ['name' => 'Surface_habitable', 'type' => 'number'],
            ['name' => 'Ce_bien_est', 'type' => 'select', 'options' => ['Meublé', 'Non Meublé']],
            ['name' => 'Nombre_de_pieces', 'type' => 'number'],
        ],
        'Informatique' => [
            ['name' => 'Processeur', 'type' => 'select', 'options' => ['Intel Core i5', 'Intel Core i7', 'AMD Ryzen 5', 'AMD Ryzen 7']],
            ['name' => 'Memoire_vive', 'type' => 'number'],
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::SPECIFICATIONS as $subCategoryName => $specifications) {
            foreach ($specifications as $specificationData) {
                $specType = new SpecificationType();
                $specType->setName($specificationData['name']);
                $specType->setType($specificationData['type']);

                if (isset($specificationData['options'])) {
                    $specType->setOptions($specificationData['options']);
                }

                $specType->setSubCategory($this->getReference($subCategoryName));
                $manager->persist($specType);
                $this->addReference($subCategoryName . '_' . $specificationData['name'], $specType);
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
