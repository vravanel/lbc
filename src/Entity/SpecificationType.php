<?php

namespace App\Entity;

use App\Repository\SpecificationTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpecificationTypeRepository::class)]
class SpecificationType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 30)]
    private ?string $type = null;

    #[ORM\Column(nullable: true)]
    private ?array $options = null;

    #[ORM\ManyToOne(inversedBy: 'specificationTypes')]
    private ?SubCategory $subCategory = null;

    /**
     * @var Collection<int, AdSpecification>
     */
    #[ORM\OneToMany(targetEntity: AdSpecification::class, mappedBy: 'specificationType')]
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getOptions(): ?array
    {
        return $this->options;
    }

    public function setOptions(?array $options): static
    {
        $this->options = $options;

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
            $adSpecification->setSpecificationType($this);
        }

        return $this;
    }

    public function removeAdSpecification(AdSpecification $adSpecification): static
    {
        if ($this->adSpecifications->removeElement($adSpecification)) {
            // set the owning side to null (unless already changed)
            if ($adSpecification->getSpecificationType() === $this) {
                $adSpecification->setSpecificationType(null);
            }
        }

        return $this;
    }
}
