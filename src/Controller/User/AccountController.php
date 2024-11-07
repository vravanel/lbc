<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Entity\UserProfile;
use App\Entity\PersonalInfo;
use App\Form\UserProfileType;
use App\Form\PersonalInfoType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
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
    public function edit(Request $request, PersonalInfo $personalInfo, EntityManagerInterface $entityManager): Response
    {
        // Vérification de l'utilisateur connecté
        if (!$this->getUser() || $personalInfo->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        // Formulaire principal avec sous-formulaires
        $form = $this->createForm(PersonalInfoType::class, $personalInfo);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('account_parameter', [id: ]);
        }

        return $this->render('user/parameter.html.twig', [
            'form' => $form->createView(),
            'personalInfo' => $personalInfo,
        ]);
    }
}
