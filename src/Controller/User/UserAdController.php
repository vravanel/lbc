<?php

namespace App\Controller\User;

use DateTime;
use App\Entity\Ad;
use App\Form\AdType;
use App\Repository\AdRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
#[Route('/compte/annonce', name: 'user_')]
class UserAdController extends AbstractController
{
    #[Route('/', name: 'ad_index', methods: ['GET'])]
    public function index(AdRepository $adRepository, Security $user, CategoryRepository $categoryRepository): Response
    {
        return $this->render('user/user_ad/index.html.twig', [
            'ads' => $adRepository->findBy(['user' => $user->getUser()], ['createAt' => "ASC"]),
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'ad_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ad = new Ad();
        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ad->setCreateAt(new DateTime());
            $entityManager->persist($ad);
            $entityManager->flush();

            return $this->redirectToRoute('user_ad_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/user_ad/new.html.twig', [
            'ad' => $ad,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'ad_show', methods: ['GET'])]
    public function show(Ad $ad): Response
    {
        return $this->render('user/user_ad/show.html.twig', [
            'ad' => $ad,
        ]);
    }

    #[Route('/{id}/edit', name: 'ad_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ad $ad, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('user_ad_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/user_ad/edit.html.twig', [
            'ad' => $ad,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'ad_delete', methods: ['POST'])]
    public function delete(Request $request, Ad $ad, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $ad->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($ad);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_ad_index', [], Response::HTTP_SEE_OTHER);
    }
}
