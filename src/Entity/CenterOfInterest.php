<?php

namespace App\Entity;

use App\Repository\CenterOfInterestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CenterOfInterestRepository::class)]
class CenterOfInterest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $centerOfInterestName = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'centerOfInterest')]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCenterOfInterestName(): ?string
    {
        return $this->centerOfInterestName;
    }

    public function setCenterOfInterestName(?string $centerOfInterestName): static
    {
        $this->centerOfInterestName = $centerOfInterestName;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addCenterOfInterest($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeCenterOfInterest($this);
        }

        return $this;
    }   
    
}
