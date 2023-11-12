<?php

namespace App\Entity;

use App\Repository\CocktailRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CocktailRepository::class)]
class Cocktail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $price = null;

    #[ORM\Column(nullable: true)]
    private ?int $alcoolIndex = null;

    #[ORM\ManyToOne(inversedBy: 'cocktails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\ManyToMany(targetEntity: Ingredient::class, inversedBy: 'cocktails')]
    private Collection $ingredient;

    #[ORM\OneToOne(inversedBy: 'cocktail', cascade: ['persist', 'remove'])]
    private ?Article $link = null;

    #[ORM\OneToMany(mappedBy: 'cocktailName', targetEntity: Gallery::class)]
    private Collection $galleries;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'cocktails')]
    private Collection $likeCocktail;

    public function __construct()
    {
        $this->ingredient = new ArrayCollection();
        $this->galleries = new ArrayCollection();
        $this->likeCocktail = new ArrayCollection();
    }
    public function __toString()
    {
        return $this->getName();
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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getAlcoolIndex(): ?int
    {
        return $this->alcoolIndex;
    }

    public function setAlcoolIndex(?int $alcoolIndex): static
    {
        $this->alcoolIndex = $alcoolIndex;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredient(): Collection
    {
        return $this->ingredient;
    }

    public function addIngredient(Ingredient $ingredient): static
    {
        if (!$this->ingredient->contains($ingredient)) {
            $this->ingredient->add($ingredient);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): static
    {
        $this->ingredient->removeElement($ingredient);

        return $this;
    }

    public function getLink(): ?Article
    {
        return $this->link;
    }

    public function setLink(?Article $link): static
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return Collection<int, Gallery>
     */
    public function getGalleries(): Collection
    {
        return $this->galleries;
    }

    public function addGallery(Gallery $gallery): static
    {
        if (!$this->galleries->contains($gallery)) {
            $this->galleries->add($gallery);
            $gallery->setCocktailName($this);
        }

        return $this;
    }

    public function removeGallery(Gallery $gallery): static
    {
        if ($this->galleries->removeElement($gallery)) {
            // set the owning side to null (unless already changed)
            if ($gallery->getCocktailName() === $this) {
                $gallery->setCocktailName(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getLikeCocktail(): Collection
    {
        return $this->likeCocktail;
    }

    public function addLikeCocktail(User $likeCocktail): static
    {
        if (!$this->likeCocktail->contains($likeCocktail)) {
            $this->likeCocktail->add($likeCocktail);
        }

        return $this;
    }

    public function removeLikeCocktail(User $likeCocktail): static
    {
        $this->likeCocktail->removeElement($likeCocktail);

        return $this;
    }

    public function isLikedByUser(User $user): bool
    {
        return $this->likeCocktail->contains($user);
    }
}
