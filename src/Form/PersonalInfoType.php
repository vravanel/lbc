<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\PersonalInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PersonalInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('civility', ChoiceType::class, [
            'choices' => [
                'Monsieur' => 'Monsieur',
                'Madame' => 'Madame',
                'Non précisé' => 'Non précisé',
            ],
            'expanded' => true,
            'multiple' => false,
            
        ])
            ->add('lastname', TextType::class)
            ->add('firstname', TextType::class)
            ->add('dateOfBirth', TextType::class)
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PersonalInfo::class,
        ]);
    }
}
