<?php

namespace App\Twig\Components;

use App\Entity\Ad;
use App\Entity\CategorySpecification;
use App\Form\AdType;
use App\Form\CategorySpecificationType;
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

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(
            AdType::class,
            $this->ad
        );
    }
}
