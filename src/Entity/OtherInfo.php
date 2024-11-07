<?php

namespace App\Entity;

use App\Repository\OtherInfoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OtherInfoRepository::class)]
class OtherInfo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $categorySocioprofessional = null;

    #[ORM\OneToOne(inversedBy: 'otherInfo', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategorySocioprofessional(): ?string
    {
        return $this->categorySocioprofessional;
    }

    public function setCategorySocioprofessional(?string $categorySocioprofessional): static
    {
        $this->categorySocioprofessional = $categorySocioprofessional;

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
}
