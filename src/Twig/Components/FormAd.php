<?php

namespace App\Twig\Components;

use App\Entity\Ad;
use App\Entity\SpecificationType;
use App\Form\AdType;
use App\Repository\SpecificationTypeRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\LiveCollectionTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent]
class FormAd extends AbstractController
{
    use DefaultActionTrait;
    use LiveCollectionTrait;

    #[LiveProp(fieldName: 'formData')]
    public ?Ad $ad;

    #[LiveProp]
    public ?SpecificationType $specificationsTypes = null;

    public function __construct(private SpecificationTypeRepository $specTypeRepo) {}

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(
            AdType::class,
            $this->ad,
        );
    }

    public function getAll(): array
    {
        return $this->specTypeRepo->findAll();
    }
}
