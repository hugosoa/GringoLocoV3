<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $numTel = null;

    #[ORM\Column(length: 255)]
    private ?string $resName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $specialAsk = null;

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

    public function getResName(): ?string
    {
        return $this->resName;
    }

    public function setResName(string $resName): static
    {
        $this->resName = $resName;

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
}
