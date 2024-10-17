<?php

namespace App\Form;

use App\Entity\Ad;
use App\Entity\AdSpecification;
use App\Entity\CategorySpecification;
use App\Entity\SubCategory;
use App\Repository\CategorySpecificationRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfonycasts\DynamicForms\DynamicFormBuilder;
use Symfonycasts\DynamicForms\DependentField;

class AdType extends AbstractType
{
    public function __construct(private CategorySpecificationRepository $categorySpecRepository) {}

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
            ->addDependent('adSpecifications', 'subCategory', function (DependentField $field, ?SubCategory $subCategory) {
                if ($subCategory === null) {
                    return;
                }

                $categorySpecs = $this->categorySpecRepository->findBy(['subCategory' => $subCategory]);

                foreach ($categorySpecs as $categorySpec) {
                    $field->add(EntityType::class, [
                        'class' => AdSpecification::class,
                        'choice_label' => 'value',
                        'label' => $categorySpec->getName(),
                        'placeholder' => 'Sélectionner une spécification',
                        'multiple' => false,
                        'mapped' => false,
                    ]);
                }
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
