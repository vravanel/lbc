<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\OtherInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OtherInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('categorySocioprofessional', ChoiceType::class, [
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
            ]])

            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OtherInfo::class,
        ]);
    }
}
