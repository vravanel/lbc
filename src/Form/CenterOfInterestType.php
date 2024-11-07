<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\CenterOfInterest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class CenterOfInterestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('centerOfInterestName', EntityType::class, [
            'class' => CenterOfInterest::class,   // Lier à l'entité CenterOfInterest
            'choice_label' => 'centerOfInterestName', // Afficher le nom du centre d'intérêt
            'multiple' => true,  // Permet de sélectionner plusieurs options
            'expanded' => true,   // Affiche sous forme de cases à cocher
            'label' => 'Centres d\'intérêt',  // Label du champ
        ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CenterOfInterest::class,
        ]);
    }
    
}
