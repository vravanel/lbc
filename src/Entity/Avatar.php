<?php

namespace App\Entity;

use App\Repository\AvatarRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvatarRepository::class)]
class Avatar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $filename = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $filepath = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $uploadedAt = null;

    #[ORM\OneToOne(inversedBy: 'avatar', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): static
    {
        $this->filename = $filename;

        return $this;
    }

    public function getFilepath(): ?string
    {
        return $this->filepath;
    }

    public function setFilepath(?string $filepath): static
    {
        $this->filepath = $filepath;

        return $this;
    }

    public function getUploadedAt(): ?\DateTimeImmutable
    {
        return $this->uploadedAt;
    }

    public function setUploadedAt(?\DateTimeImmutable $uploadedAt): static
    {
        $this->uploadedAt = $uploadedAt;

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
