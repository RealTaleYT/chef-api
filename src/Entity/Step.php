<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
class Step
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    #[Groups(['Recipe'])]
    private ?int $id = null;

    #[ORM\Column(type:"integer")]
    #[Groups(['Recipe'])]
    private ?int $stepOrder = null;

    #[ORM\Column(type:"string", length:1000)]
    #[Groups(['Recipe'])]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity:Recipe::class, inversedBy:"steps")]
    #[ORM\JoinColumn(nullable:false)]
    private ?Recipe $recipe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStepOrder(): ?int
    {
        return $this->stepOrder;
    }

    public function setStepOrder(int $stepOrder): self
    {
        $this->stepOrder = $stepOrder;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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
