<?php

namespace App\Form;

use App\Entity\Ad;
use App\Entity\SubCategory;
use Symfony\Component\Form\AbstractType;
use Symfonycasts\DynamicForms\DependentField;
use App\Repository\SpecificationTypeRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfonycasts\DynamicForms\DynamicFormBuilder;
use App\Repository\CategorySpecificationRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AdType extends AbstractType
{
    public function __construct(private SpecificationTypeRepository $specTypeRepository) {}

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
            ->addDependent('marque', 'subCategory', function (DependentField $field, ?SubCategory $subCategory) {
                if ($subCategory === null) {
                    return;
                }

                $specificationType = $this->specTypeRepository->findOneBy(['subCategory' => $subCategory, 'name' => 'Marque']);
                $field->add(ChoiceType::class, [
                    'choices' => array_combine($specificationType->getOptions(), $specificationType->getOptions()),
                    'label' => $specificationType->getName(),
                    'placeholder' => 'Sélectionner une spécification',
                    'multiple' => false,
                    'expanded' => false,
                    'mapped' => false,
                ]);
            })
            ->addDependent('modele', 'subCategory', function (DependentField $field, ?SubCategory $subCategory) {
                if ($subCategory === null) {
                    return;
                }

                $specificationType = $this->specTypeRepository->findOneBy(['subCategory' => $subCategory, 'name' => 'Modele']);
                $field->add(TextType::class, [
                    'label' => $specificationType->getName(),
                    'mapped' => false,
                ]);
            })

            ->addDependent('kilometrage', 'subCategory', function (DependentField $field, ?SubCategory $subCategory) {
                if ($subCategory === null) {
                    return;
                }

                $specificationType = $this->specTypeRepository->findOneBy(['subCategory' => $subCategory, 'name' => 'Kilometrage']);
                $field->add(NumberType::class, [
                    'label' => $specificationType->getName(),
                    'mapped' => false,
                ]);
            })

            ->addDependent('carburant', 'subCategory', function (DependentField $field, ?SubCategory $subCategory) {
                if ($subCategory === null) {
                    return;
                }

                $specificationType = $this->specTypeRepository->findOneBy(['subCategory' => $subCategory, 'name' => 'Carburant']);
                $field->add(ChoiceType::class, [
                    'choices' => array_combine($specificationType->getOptions(), $specificationType->getOptions()),
                    'label' => $specificationType->getName(),
                    'placeholder' => 'Sélectionner un type de carburant',
                    'multiple' => false,
                    'expanded' => false,
                    'mapped' => false,
                ]);
            })

            ->addDependent('transmission', 'subCategory', function (DependentField $field, ?SubCategory $subCategory) {
                if ($subCategory === null) {
                    return;
                }

                $specificationType = $this->specTypeRepository->findOneBy(['subCategory' => $subCategory, 'name' => 'Transmission']);
                $field->add(ChoiceType::class, [
                    'choices' => array_combine($specificationType->getOptions(), $specificationType->getOptions()),
                    'label' => $specificationType->getName(),
                    'placeholder' => 'Sélectionner une transmission',
                    'multiple' => false,
                    'expanded' => false,
                    'mapped' => false,
                ]);
            })

            ->addDependent('couleur', 'subCategory', function (DependentField $field, ?SubCategory $subCategory) {
                if ($subCategory === null) {
                    return;
                }

                $specificationType = $this->specTypeRepository->findOneBy(['subCategory' => $subCategory, 'name' => 'Couleur']);
                $field->add(TextType::class, [
                    'label' => $specificationType->getName(),
                    'mapped' => false,
                ]);
            })
            ->add('description')
            ->add('price')
            ->add('city')
            ->add('zipCode');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
