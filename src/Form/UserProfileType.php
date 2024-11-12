<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\UserProfile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Section 1: Informations Personnelles
        $builder
            ->add('civility', ChoiceType::class, [
                'choices' => [
                    'Monsieur' => 'Monsieur',
                    'Madame' => 'Madame',
                    'Non précisé' => 'Non précisé',
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => false,
            ])
            ->add('lastname', TextType::class, [
                'required' => false,
            ])
            ->add('firstname', TextType::class, [
                'required' => false,
            ])
            ->add('birthdate', DateType::class, [
                'required' => false,
            ])
            ->add('personalInfo', SubmitType::class, [
                'label' => 'Sauvegarder Informations Personnelles'
            ]);

        // Section 2: Autres Informations
        $builder
            ->add('adress', TextType::class, [
                'required' => false,
            ])
            ->add('mail', EmailType::class, [
                'required' => false,
            ])
            ->add('categorySocioprofessionnal', ChoiceType::class, [
                'choices' => [
                    'Cadre / Dirigeant' => 'Cadre / Dirigeant',
                    'Profession libérale' => 'Profession libérale',
                    'Technicien / Agent de maîtrise' => 'Technicien / Agent de maîtrise',
                    'Professeur / Enseignant' => 'Professeur / Enseignant',
                    'Service aux particuliers' => 'Service aux particuliers',
                    'Artisan' => 'Artisan',
                    'Employé de bureau ou administratif' => 'Employé de bureau ou administratif',
                    'Commerçant' => 'Commerçant',
                    'Ouvrier' => 'Ouvrier',
                    'Retraité' => 'Retraité',
                    'Etudiant' => 'Etudiant',
                    'Femme / Homme au foyer' => 'Femme / Homme au foyer',
                    'Militaire' => 'Militaire',
                    'Sans emploi' => 'Sans emploi',
                ],
                'required' => false,
            ])
            ->add('otherInfo', SubmitType::class, [
                'label' => 'Sauvegarder Autres Informations'
            ]);
            /*->add('user', EntityType::class, [
                'label' => false,
                'class' => User::class,
                'choice_label' => 'id',
                'attr' => ['style' => 'display:none;'],
                'data' => $options['data']->getUser()  // Associer l'utilisateur actuel
            ]);*/
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserProfile::class,
            'no_prefill' => false,
        ]);
    }
}
