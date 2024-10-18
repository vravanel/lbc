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
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

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
            });
        $specificationsType = $this->specTypeRepository->findAll();
        foreach ($specificationsType as $specificationType) {
            $builder->addDependent('adSpecification_' . $specificationType->getName(), 'subCategory', function (DependentField $field, ?SubCategory $subCategory) use ($specificationType) {
                if ($subCategory === null) {
                    return;
                }

                if ($specificationType->getType() === 'select' & $specificationType->getSubCategory() === $subCategory) {
                    $field->add(ChoiceType::class, [
                        'choices' => array_combine($specificationType->getOptions(), $specificationType->getOptions()),
                        'label' => $specificationType->getName(),
                        'placeholder' => 'Sélectionner une spécification',
                        'multiple' => false,
                        'expanded' => false,
                        'mapped' => false,
                    ]);
                }

                if ($specificationType->getType() === 'text' & $specificationType->getSubCategory() === $subCategory) {
                    $field->add(TextType::class, [
                        'label' => $specificationType->getName(),
                        'mapped' => false,
                    ]);
                }

                if ($specificationType->getType() === 'number' & $specificationType->getSubCategory() === $subCategory) {
                    $field->add(NumberType::class, [
                        'label' => $specificationType->getName(),
                        'mapped' => false,
                    ]);
                }
            });
        }
        $builder
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
