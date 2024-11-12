<?php

namespace App\Twig\Components\AccountParameter;

use App\Entity\User;
use App\Entity\PersonalInfo;
use App\Form\PersonalInfoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent]
final class PersonalInfoForm extends AbstractController
{
    use ComponentWithFormTrait;
    use DefaultActionTrait;

    #[LiveProp]
    public ?User $user;

    #[LiveProp]
    public ?PersonalInfo $personalInfo = null;

    public function __construct(Security $security)
    {
        $this->user = $this->user ?? $security->getUser(); // Utilise le `LiveProp` ou prend l'utilisateur connecté
    }
    
    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(PersonalInfoType::class, $this->personalInfo);
    }
    
    #[LiveAction]
    public function save(EntityManagerInterface $entityManager)
    {
        // Submit the form! If validation fails, an exception is thrown
        // and the component is automatically re-rendered with the errors
        $this->submitForm();

        /** @var Post $post */
        $this->personalInfo = $this->getForm()->getData();
        $entityManager->persist($this->personalInfo);
        $entityManager->flush();

        $this->addFlash('success', 'Post saved!');
        
    }

}
