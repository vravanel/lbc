<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Entity\UserProfile;
use App\Form\UserProfileType;
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
    public function index(UserProfile $userProfile): Response
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
    public function edit(Request $request, UserProfile $userProfile, EntityManagerInterface $entityManager): Response
    {
        // Vérification de l'utilisateur connecté
        if (!$this->getUser() || $userProfile->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        // Formulaire principal avec sous-formulaires
        $form = $this->createForm(UserProfileType::class, $userProfile);
        $form->handleRequest($request);
        
        // Soumission pour "Informations Personnelles"
        if ($form->getClickedButton('personalInfo')=== $form->get('personalInfo') && $form->get('personalInfo')->isValid()) {
            // Sauvegarder les informations personnelles
            
            $entityManager->flush();
            $this->addFlash('success', 'Informations personnelles mises à jour.');
        }

        // Soumission pour "Autres Informations"
        if ($form->get('otherInfo')->isSubmitted() && $form->get('otherInfo')->isValid()) {
            // Sauvegarder les autres informations
            $entityManager->flush();
            $this->addFlash('success', 'Autres informations mises à jour.');
        }

        return $this->render('user/parameter.html.twig', [
            'form' => $form->createView(),
            'userProfile' => $userProfile,
        ]);
    }
}
