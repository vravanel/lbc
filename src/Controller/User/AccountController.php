<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Entity\Address;
use App\Entity\OtherInfo;
use App\Entity\PersonalInfo;
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
    public function index(PersonalInfo $personalInfo,): Response
    {
        if (!$this->getUser() || $personalInfo->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('user/index.html.twig', [
            'personalInfo' => $personalInfo
        ]);
    }

    #[Route('/parameter/{id}', methods: ['GET', 'POST'], name: '_parameter')]
    public function edit(
        PersonalInfo $personalInfo,
        Address $addressInfo,
        User $interestInfo,
        OtherInfo $otherInfo,
        User $emailUserInfo
    ): Response {
        if (!$this->getUser() || $personalInfo->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        return $this->render('user/parameter.html.twig', [
            'addressData' => $addressInfo,
            'interestData' => $interestInfo,
            'otherInfoData' => $otherInfo,
            'emailData' => $emailUserInfo,
            'personalInfoData' => $personalInfo,
        ]);
    }
}
