<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Avatar;
use App\Entity\Address;
use App\Entity\OtherInfo;
use App\Entity\PersonalInfo;
use App\Entity\CenterOfInterest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['email_only']) {
            $builder->add('email', EmailType::class);
        } elseif ($options['interest_only']) {
            $builder->add('centerOfInterest', EntityType::class, [
                'class' => CenterOfInterest::class,
                'choice_label' => 'centerOfInterestName',
                'multiple' => true,  // Permet de sélectionner plusieurs options
                'expanded' => true,   // Affiche sous forme de cases à cocher
                'label' => 'Centres d\'intérêt',
            ]);
        } else {
            $builder
                ->add('email')
                ->add('password')
                ->add('username')
                ->add('phone')
                ->add('createdAt', null, [
                    'widget' => 'single_text',
                ])
                ->add('updatedAt', null, [
                    'widget' => 'single_text',
                ])
                ->add('address', EntityType::class, [
                    'class' => Address::class,
                    'choice_label' => 'id',
                ])
                ->add('avatar', EntityType::class, [
                    'class' => Avatar::class,
                    'choice_label' => 'id',
                ])
                ->add('centerOfInterest', EntityType::class, [
                    'class' => CenterOfInterest::class,
                    'choice_label' => 'id',
                    'multiple' => true,
                ])
                ->add('otherInfo', EntityType::class, [
                    'class' => OtherInfo::class,
                    'choice_label' => 'id',
                ])
                ->add('personalInfo', EntityType::class, [
                    'class' => PersonalInfo::class,
                    'choice_label' => 'id',
                ])
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'email_only' => false, // Par défaut, tous les champs sont inclus
            'interest_only' => false,
        ]);
    }
}
