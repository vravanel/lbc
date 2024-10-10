<?php

namespace App\Entity;

use App\Repository\CategorySpecificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorySpecificationRepository::class)]
class CategorySpecification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $isRequired = null;

    #[ORM\ManyToOne(inversedBy: 'categorySpecifications')]
    private ?SubCategory $subCategory = null;

    /**
     * @var Collection<int, AdSpecification>
     */
    #[ORM\OneToMany(targetEntity: AdSpecification::class, mappedBy: 'categorySpecification')]
    private Collection $adSpecifications;

    public function __construct()
    {
        $this->adSpecifications = new ArrayCollection();
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

    public function isRequired(): ?bool
    {
        return $this->isRequired;
    }

    public function setRequired(bool $isRequired): static
    {
        $this->isRequired = $isRequired;

        return $this;
    }

    public function getSubCategory(): ?SubCategory
    {
        return $this->subCategory;
    }

    public function setSubCategory(?SubCategory $subCategory): static
    {
        $this->subCategory = $subCategory;

        return $this;
    }

    /**
     * @return Collection<int, AdSpecification>
     */
    public function getAdSpecifications(): Collection
    {
        return $this->adSpecifications;
    }

    public function addAdSpecification(AdSpecification $adSpecification): static
    {
        if (!$this->adSpecifications->contains($adSpecification)) {
            $this->adSpecifications->add($adSpecification);
            $adSpecification->setCategorySpecification($this);
        }

        return $this;
    }

    public function removeAdSpecification(AdSpecification $adSpecification): static
    {
        if ($this->adSpecifications->removeElement($adSpecification)) {
            // set the owning side to null (unless already changed)
            if ($adSpecification->getCategorySpecification() === $this) {
                $adSpecification->setCategorySpecification(null);
            }
        }

        return $this;
    }
}
