<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
class Nutrient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    #[Groups(['Recipe'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity:NutrientType::class)]
    #[ORM\JoinColumn(nullable:false)]
    #[Groups(['Recipe'])]
    private ?NutrientType $type = null;

    #[ORM\Column(type:"float")]
    #[Groups(['Recipe'])]
    private ?float $quantity = null;

    #[ORM\ManyToOne(targetEntity:Recipe::class, inversedBy:"nutrients")]
    #[ORM\JoinColumn(nullable:false)]
    private ?Recipe $recipe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?NutrientType
    {
        return $this->type;
    }

    public function setType(?NutrientType $type): self
    {
        $this->type = $type;

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
