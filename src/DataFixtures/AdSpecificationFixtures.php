<?php

namespace App\DataFixtures;

use App\Entity\AdSpecification;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AdSpecificationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 5; $i++) {
            $adSpec = new AdSpecification();
            $adSpec->setAd($this->getReference('Voitures' . $i));
            $adSpec->setCategorySpecification($this->getReference('Voitures_Marque'));
            $adSpec->setValue('Toyota');
            $manager->persist($adSpec);

            $adSpec2 = new AdSpecification();
            $adSpec2->setAd($this->getReference('Voitures' . $i));
            $adSpec2->setCategorySpecification($this->getReference('Voitures_Kilométrage'));
            $adSpec2->setValue(strval(rand(50000, 150000)));
            $manager->persist($adSpec2);
        }

        for ($i = 0; $i < 5; $i++) {
            $adSpec3 = new AdSpecification();
            $adSpec3->setAd($this->getReference('Locations' . $i));
            $adSpec3->setCategorySpecification($this->getReference('Locations_Surface habitable'));
            $adSpec3->setValue(strval(rand(30, 100)));
            $manager->persist($adSpec3);

            $adSpec4 = new AdSpecification();
            $adSpec4->setAd($this->getReference('Locations' . $i));
            $adSpec4->setCategorySpecification($this->getReference('Locations_Ce bien est'));
            $adSpec4->setValue(rand(0, 1) ? 'Meublé' : 'Non Meublé');
            $manager->persist($adSpec4);

            $adSpec5 = new AdSpecification();
            $adSpec5->setAd($this->getReference('Locations' . $i));
            $adSpec5->setCategorySpecification($this->getReference('Locations_Type de bien'));
            $adSpec5->setValue(rand(0, 1) ? 'Appartement' : 'Maison');
            $manager->persist($adSpec5);

            $adSpec6 = new AdSpecification();
            $adSpec6->setAd($this->getReference('Locations' . $i));
            $adSpec6->setCategorySpecification($this->getReference('Locations_Nombre de pièces'));
            $adSpec6->setValue(strval(rand(1,5)));
            $manager->persist($adSpec6);
        }

        for ($i = 0; $i < 5; $i++) {
            $adSpec7 = new AdSpecification();
            $adSpec7->setAd($this->getReference('Informatique' . $i));
            $adSpec7->setCategorySpecification($this->getReference('Informatique_Processeur'));
            $adSpec7->setValue('Intel Core i7');
            $manager->persist($adSpec7);

            $adSpec8 = new AdSpecification();
            $adSpec8->setAd($this->getReference('Informatique' . $i));
            $adSpec8->setCategorySpecification($this->getReference('Informatique_Mémoire vive (RAM)'));
            $adSpec8->setValue(strval(rand(4, 16)));
            $manager->persist($adSpec8);
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
