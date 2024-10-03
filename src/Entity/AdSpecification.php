<?php

namespace App\Entity;

use App\Repository\AdSpecificationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdSpecificationRepository::class)]
class AdSpecification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    #[ORM\ManyToOne(inversedBy: 'adSpecifications')]
    private ?Ad $ad = null;

    #[ORM\ManyToOne(inversedBy: 'adSpecifications')]
    private ?CategorySpecification $categorySpecification = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getAd(): ?Ad
    {
        return $this->ad;
    }

    public function setAd(?Ad $ad): static
    {
        $this->ad = $ad;

        return $this;
    }

    public function getCategorySpecification(): ?CategorySpecification
    {
        return $this->categorySpecification;
    }

    public function setCategorySpecification(?CategorySpecification $categorySpecification): static
    {
        $this->categorySpecification = $categorySpecification;

        return $this;
    }
}
