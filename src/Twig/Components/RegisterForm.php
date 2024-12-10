<?php

namespace App\Twig\Components;

use App\Entity\User;
use App\Enum\UserTypeEnum;
use App\Service\SinchService;
use Symfony\Component\Mime\Email;
use App\Form\RegistrationFormType;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\LiveCollectionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsLiveComponent]
final class RegisterForm extends AbstractController
{
    use ComponentToolsTrait;
    use DefaultActionTrait;
    use LiveCollectionTrait;

    #[LiveProp(writable: true)]
    public string $code1 = '';

    #[LiveProp(writable: true)]
    public string $code2 = '';

    #[LiveProp(writable: true)]
    public string $code3 = '';

    #[LiveProp(writable: true)]
    public string $code4 = '';

    #[LiveProp(writable: true)]
    public string $code5 = '';

    #[LiveProp(writable: true)]
    public string $code6 = '';

    #[LiveProp(writable: true)]
    public string $codeVerifier = '';

    #[LiveProp(writable: true)]
    public int $step = 0;

    #[LiveProp(writable: true)]
    public ?string $email = null;

    #[LiveProp(writable: true)]
    public ?string $password = null;

    #[LiveProp(writable: true)]
    public ?string $phone = null;

    #[LiveProp(writable: true)]
    public ?bool $isValid = false;

    #[LiveProp(writable: true)]
    public ?bool $isValidPhone = null;

    #[LiveProp]
    public ?User $user = null;

    #[LiveProp(writable: true)]
    public string $codePhone1 = '';

    #[LiveProp(writable: true)]
    public string $codePhone2 = '';

    #[LiveProp(writable: true)]
    public string $codePhone3 = '';

    #[LiveProp(writable: true)]
    public string $codePhone4 = '';

    #[LiveProp(writable: true)]
    public ?UserTypeEnum $userType = null;

    public function __construct(private MailerInterface $mailer, private SinchService $sinchService, private UserPasswordHasherInterface $passwordHasher) {}


    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(
            RegistrationFormType::class,
        );
    }

    public function hasValidationErrorEmail(): bool
    {
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false) {
            return  true;
        } else {
            return false;
        }
    }

    #[LiveListener('step')]
    public function incrementStep()
    {
        $this->step++;
    }

    #[LiveListener('step2')]
    public function decrementStep()
    {
        $this->step--;
    }

    #[LiveAction]
    public function codeEmail()
    {
        if (empty($this->email)) {
            return;
        }
        $this->codeVerifier = strval(rand(100000, 999999));
        $email = (new Email())
            ->from(new Address('test@test.com', 'LBC'))
            ->to($this->email)
            ->subject('Please Confirm your Email')
            ->html('<p>Voici le code: ' . $this->codeVerifier . '</p>');
        $this->mailer->send($email);
        $this->emit('step');
    }

    #[LiveAction]
    public function validateCode(): void
    {
        $code = $this->code1 . $this->code2 . $this->code3 . $this->code4 . $this->code5 . $this->code6;
        $this->isValid = $code === $this->codeVerifier;
        $this->emit('step');
        if ($this->isValid === true) {
        }
    }

    public function hasValidationErrorPassword(): bool
    {
        if (!empty($this->password)) {
            return  true;
        } else {
            return false;
        }
    }

    public function hasValidationErrorPhone(): bool
    {
        if (!empty($this->phone)) {
            return  true;
        } else {
            return false;
        }
    }

    #[LiveAction]
    public function verifyPhone()
    {
        $this->sinchService->sendVerificationSms();
        $this->emit('step');
    }

    #[LiveAction]
    public function validateCodePhone(EntityManagerInterface $entityManager): void
    {
        $codePhone = $this->codePhone1 . $this->codePhone2 . $this->codePhone3 . $this->codePhone4;

        if ($this->sinchService->checkVerificationCode($codePhone) === true) {
            $this->saveRegistration($entityManager);
        }
    }

    #[LiveAction]
    public function saveRegistration(EntityManagerInterface $entityManager)
    {
        $this->user = new User();
        $this->user->setPhoneVerified(true);
        $this->user->setEmail($this->email);
        $this->user->setPassword($this->passwordHasher->hashPassword($this->user, $this->password));
        $this->user->setPhone($this->phone);
        $this->user->setVerified(true);
        $this->user->setUserType($this->userType);
        $entityManager->persist($this->user);
        $entityManager->flush();
        $this->redirectToRoute('app_home');
    }
}
