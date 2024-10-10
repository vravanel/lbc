<?php

namespace App\Controller;

use App\Entity\SubCategory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/category', name: 'subCategory_')]
class SubCategoryController extends AbstractController
{
    #[Route('/{subCategory}', name: 'show')]
    public function show(SubCategory $subCategory): Response
    {
        return $this->render('subCategory/show.html.twig', [
            'subCategory' => $subCategory
        ]);
    }
}
