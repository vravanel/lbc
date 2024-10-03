<?php

namespace App\Entity;

use App\Repository\SubCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubCategoryRepository::class)]
class SubCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'subCategories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    /**
     * @var Collection<int, Ad>
     */
    #[ORM\OneToMany(targetEntity: Ad::class, mappedBy: 'subCategory')]
    private Collection $ads;

    /**
     * @var Collection<int, CategorySpecification>
     */
    #[ORM\OneToMany(targetEntity: CategorySpecification::class, mappedBy: 'subcategory')]
    private Collection $categorySpecifications;

    public function __construct()
    {
        $this->ads = new ArrayCollection();
        $this->categorySpecifications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Ad>
     */
    public function getAds(): Collection
    {
        return $this->ads;
    }

    public function addAd(Ad $ad): static
    {
        if (!$this->ads->contains($ad)) {
            $this->ads->add($ad);
            $ad->setSubCategory($this);
        }

        return $this;
    }

    public function removeAd(Ad $ad): static
    {
        if ($this->ads->removeElement($ad)) {
            // set the owning side to null (unless already changed)
            if ($ad->getSubCategory() === $this) {
                $ad->setSubCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CategorySpecification>
     */
    public function getCategorySpecifications(): Collection
    {
        return $this->categorySpecifications;
    }

    public function addCategorySpecification(CategorySpecification $categorySpecification): static
    {
        if (!$this->categorySpecifications->contains($categorySpecification)) {
            $this->categorySpecifications->add($categorySpecification);
            $categorySpecification->setSubcategory($this);
        }

        return $this;
    }

    public function removeCategorySpecification(CategorySpecification $categorySpecification): static
    {
        if ($this->categorySpecifications->removeElement($categorySpecification)) {
            // set the owning side to null (unless already changed)
            if ($categorySpecification->getSubcategory() === $this) {
                $categorySpecification->setSubcategory(null);
            }
        }

        return $this;
    }
}
