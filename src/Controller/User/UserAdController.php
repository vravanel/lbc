<?php

namespace App\Controller\User;

use DateTime;
use App\Entity\Ad;
use App\Form\AdType;
use App\Repository\AdRepository;
use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

#[IsGranted('ROLE_USER')]
#[Route('/compte/annonce', name: 'user_')]
class UserAdController extends AbstractController
{
    #[Route('/', name: 'ad_index', methods: ['GET'])]
    public function index(Request $request, AdRepository $adRepository, Security $user, SubCategoryRepository $subCategoryRepository, CategoryRepository $categoryRepository, PaginatorInterface $paginator): Response
    {
        $form = $this->createFormBuilder(null, ['method' => 'get'])
            ->add('search', SearchType::class)
            ->add('subCategory', ChoiceType::class, [
                'choices' => array_reduce($categoryRepository->findAll(), function ($result, $category) use ($subCategoryRepository) {
                
                    $subCategories = $subCategoryRepository->findBy(['category' => $category]);
                    $subCategoryChoices = [];
                    foreach ($subCategories as $subCategory) {
                        $subCategoryChoices[$subCategory->getName()] = $subCategory->getName();
                    }
                    $result[$category->getName()] = $subCategoryChoices;
                    return $result;
                }, [])
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->get('search')->getData();
            $subCategory = $form->get('subCategory')->getData();
            $query = $adRepository->findLikeName($search, $subCategory);
        } else {
            $query = $adRepository->findBy(['user' => $user->getUser()], ['createAt' => "ASC"]);
        }

        $pagination = $paginator->paginate($query, $request->query->getInt('page', 1), 10);

        return $this->render('user/user_ad/index.html.twig', [
            'ads' => $pagination,
            'form' => $form
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
