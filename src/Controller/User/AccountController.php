<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Address;
use App\Entity\OtherInfo;
use App\Form\AddressType;
use App\Form\OtherInfoType;
use App\Entity\PersonalInfo;
use App\Form\PersonalInfoType;
use App\Entity\CenterOfInterest;
use App\Form\CenterOfInterestType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
#[Route('/account', name: 'account')]
class AccountController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/{id}', name: '_index')]
    public function index(PersonalInfo $userProfile): Response
    {
        // Vérifier si l'utilisateur est connecté et correspond à son profil
        if (!$this->getUser() || $userProfile->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('user/index.html.twig', [
            'userProfile' => $userProfile,
        ]);
    }

    #[Route('/parameter/{id}', methods: ['GET', 'POST'], name: '_parameter')]
    public function edit(
        Request $request,
        PersonalInfo $personalInfo,
        EntityManagerInterface $entityManager,
        Address $addressInfo,
        User $interest,
        OtherInfo $otherInfo,
        User $mailUser
        ): Response
    {
        $user = $personalInfo->getUser();

        // Vérification de l'utilisateur connecté
        if (!$this->getUser() || $personalInfo->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        // Création des formulaires
        $formPI = $this->createForm(PersonalInfoType::class, $personalInfo);
        $formAddress = $this->createForm(AddressType::class, $addressInfo);
        $formInterest = $this->createForm(UserType::class, $interest, ['interest_only' => true]);
        $formOtherInfo = $this->createForm(OtherInfoType::class, $otherInfo);
        $formEmail = $this->createForm(UserType::class, $mailUser, ['email_only' => true]);


        // Gère chaque formulaire en appelant handleForm
        if ($this->handleForm($request, $formPI, $entityManager)) {
            return $this->redirectToRoute('account_parameter', ['id' => $user->getId()]);
        }
        if ($this->handleForm($request, $formAddress, $entityManager)) {
            return $this->redirectToRoute('account_parameter', ['id' => $user->getId()]);
        }
        if ($this->handleForm($request, $formInterest, $entityManager)) {
            return $this->redirectToRoute('account_parameter', ['id' => $user->getId()]);
        }
        if ($this->handleForm($request, $formOtherInfo, $entityManager)) {
            return $this->redirectToRoute('account_parameter', ['id' => $user->getId()]);
        }
        if ($this->handleForm($request, $formEmail, $entityManager)) {
            return $this->redirectToRoute('account_parameter', ['id' => $user->getId()]);
        }

        // Envoie tous les formulaires à la vue
        return $this->render('user/parameter.html.twig', [
            'formPI' => $formPI->createView(),
            'formAddress' => $formAddress->createView(),
            'formInterest' => $formInterest->createView(),
            'formOtherInfo' => $formOtherInfo->createView(),
            'formEmail' => $formEmail->createView(),
            'personalInfo' => $personalInfo,
        ]);
    }

    private function handleForm(Request $request, $form, $entityManager)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return true;  // Renvoie "true" si le formulaire est validé
        }

        return false;  // Renvoie "false" si le formulaire n'a pas été validé
    }
}
