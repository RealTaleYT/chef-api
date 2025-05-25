<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    #[Groups(['Recipe'])]
    private ?int $id = null;

    #[ORM\Column(type:"string", length:255)]
    #[Groups(['Recipe'])]
    private ?string $name = null;

    #[ORM\Column(type:"float")]
    #[Groups(['Recipe'])]
    private ?float $quantity = null;

    #[ORM\Column(type:"string", length:50)]
    #[Groups(['Recipe'])]
    private ?string $unit = null;

    #[ORM\ManyToOne(targetEntity:Recipe::class, inversedBy:"ingredients")]
    #[ORM\JoinColumn(nullable:false)]
    private ?Recipe $recipe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipe $recipe): self
    {
        $this->recipe = $recipe;

        return $this;
    }
}
