<?php

namespace App\Form;

use App\Entity\User;
use App\Enum\UserTypeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfonycasts\DynamicForms\DynamicFormBuilder;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('userType', EnumType::class, [
                'class' => UserTypeEnum::class,
                'expanded' => true,
                'multiple' => false,
                'label' => UserTypeEnum::class,
                'attr' => [
                    'class' => 'form-check'
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])

            ->add('number1', NumberType::class, [
                'mapped' => false,
                'required' => false,
                'label' => false,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('number2', NumberType::class, [
                'mapped' => false,
                'required' => false,
                'label' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('number3', NumberType::class, [
                'mapped' => false,
                'label' => false,
                'required' => false,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('number4', NumberType::class, [
                'mapped' => false,
                'required' => false,
                'label' => false,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('number5', NumberType::class, [
                'mapped' => false,
                'required' => false,
                'label' => false,
                'attr' => ['class' => 'form-control',],
            ])
            ->add('number6', NumberType::class, [
                'mapped' => false,
                'required' => false,
                'label' => false,
                'attr' => ['class' => 'form-control'],
            ])

            ->add('phone', NumberType::class, [
                'attr' => ['class' => 'form-control'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
