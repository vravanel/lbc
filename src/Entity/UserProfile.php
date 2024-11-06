<?php

namespace App\Entity;

use App\Repository\UserProfileRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserProfileRepository::class)]
class UserProfile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20, nullable:true)]
    private ?string $civility = null;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $firstname = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable:true)]
    private ?\DateTimeInterface $birthdate = null;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $adress = null;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $mail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $categorySocioprofessionnal = null;

    #[ORM\OneToOne(inversedBy: 'userProfile', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getCivility(): ?string
    {
        return $this->civility;
    }

    public function setCivility(string $civility): static
    {
        $this->civility = $civility;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): static
    {
        $this->adress = $adress;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getCategorySocioprofessionnal(): ?string
    {
        return $this->categorySocioprofessionnal;
    }

    public function setCategorySocioprofessionnal(?string $categorySocioprofessionnal): static
    {
        $this->categorySocioprofessionnal = $categorySocioprofessionnal;

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
