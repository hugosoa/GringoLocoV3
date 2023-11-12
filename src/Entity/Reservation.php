<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $numTel = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $specialAsk = null;

    #[ORM\Column]
    private ?int $nbrPeople = null;

    #[ORM\Column]
    #[Gedmo\Timestampable(on: "create")]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $bookedAt = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?User $author = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumTel(): ?string
    {
        return $this->numTel;
    }

    public function setNumTel(string $numTel): static
    {
        $this->numTel = $numTel;

        return $this;
    }

    public function getSpecialAsk(): ?string
    {
        return $this->specialAsk;
    }

    public function setSpecialAsk(?string $specialAsk): static
    {
        $this->specialAsk = $specialAsk;

        return $this;
    }

    public function getNbrPeople(): ?int
    {
        return $this->nbrPeople;
    }

    public function setNbrPeople(int $nbrPeople): static
    {
        $this->nbrPeople = $nbrPeople;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getBookedAt(): ?\DateTimeInterface
    {
        return $this->bookedAt;
    }

    public function setBookedAt(\DateTimeInterface $bookedAt): self
    {
        $this->bookedAt = $bookedAt;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }
}
