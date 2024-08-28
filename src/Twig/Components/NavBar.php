<?php

namespace App\Twig\Components;

use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class NavBar
{

    public function __construct(
        private CategoryRepository $categoryRepository,
        private SubCategoryRepository $subCategoryRepository
    ) {}

    public function getCategories(): array
    {
        return $this->categoryRepository->findAll();
    }

    public function getCategoriesWithSubCategories(): array
    {
        $categories = $this->categoryRepository->findAll();
        $categoriesWithSubCategories = [];

        foreach ($categories as $category) {
            $subCategories = $this->subCategoryRepository->findBy(['category' => $category]);
            $categoriesWithSubCategories[] = [
                'category' => $category,
                'subCategories' => $subCategories,
            ];
        }

        return $categoriesWithSubCategories;
    }
}
