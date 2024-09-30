<?php

namespace App\Form;

use App\Entity\Ad;
use App\Entity\SubCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfonycasts\DynamicForms\DynamicFormBuilder;
use Symfonycasts\DynamicForms\DependentField;

class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder = new DynamicFormBuilder($builder);

        $builder
            ->add('title')
            ->addDependent('subCategory', 'title', function (DependentField $field, ?string $title) {
                if ($title === null) {
                    return;
                }
                $field->add(EntityType::class, [
                    'class' => SubCategory::class,
                    'choice_label' => 'name',
                ]);
            })
            ->add('description')
            ->add('price')
            ->add('city')
            ->add('zipCode')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
