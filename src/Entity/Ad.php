<?php

namespace App\Entity;

use App\Enum\AdStateEnum;
use Doctrine\DBAL\Types\Types;
use App\Repository\AdRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: AdRepository::class)]
class Ad
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?\DateTime $createAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updateAt = null;

    #[ORM\Column(length: 90)]
    private ?string $city = null;

    #[ORM\Column(length: 6)]
    private ?string $zipCode = null;

    #[ORM\ManyToOne(inversedBy: 'ads')]
    #[ORM\JoinColumn(nullable: false)]
    private ?SubCategory $subCategory = null;

    /**
     * @var Collection<int, Image>
     */
    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'ad')]
    private Collection $images;

    #[ORM\ManyToOne(inversedBy: 'ads')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, AdSpecification>
     */
    #[ORM\OneToMany(targetEntity: AdSpecification::class, mappedBy: 'ad')]
    private Collection $adSpecifications;

    #[ORM\Column(type: 'string', enumType: AdStateEnum::class)]
    private AdStateEnum $state;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $specifications = null;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->adSpecifications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCreateAt(): ?\DateTime
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTime $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeImmutable $updateAt): static
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): static
    {
        $this->zipCode = $zipCode;

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
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setAd($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getAd() === $this) {
                $image->setAd(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

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
            $adSpecification->setAd($this);
        }

        return $this;
    }

    public function removeAdSpecification(AdSpecification $adSpecification): static
    {
        if ($this->adSpecifications->removeElement($adSpecification)) {
            // set the owning side to null (unless already changed)
            if ($adSpecification->getAd() === $this) {
                $adSpecification->setAd(null);
            }
        }

        return $this;
    }

    public function getState(): AdStateEnum
    {
        return $this->state;
    }

    public function setState(AdStateEnum $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getSpecifications(): ?array
    {
        return $this->specifications;
    }

    public function setSpecifications(?array $specifications): self
    {
        $this->specifications = $specifications;

        return $this;
    }
}
