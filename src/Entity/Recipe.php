<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    #[Groups(['Recipe'])]
    private ?int $id = null;

    #[ORM\Column(type:"string", length:255)]
    #[Groups(['Recipe'])]
    private ?string $title = null;

    #[ORM\Column(type:"integer")]
    #[Groups(['Recipe'])]
    private ?int $numberDiner = null;

    #[ORM\OneToMany(mappedBy:"recipe", targetEntity:Ingredient::class, cascade:["persist", "remove"], orphanRemoval:true)]
    #[Groups(['Recipe'])]
    private Collection $ingredients;

    #[ORM\OneToMany(mappedBy:"recipe", targetEntity:Step::class, cascade:["persist", "remove"], orphanRemoval:true)]
    #[Groups(['Recipe'])]
    private Collection $steps;

    #[ORM\OneToMany(mappedBy:"recipe", targetEntity:Nutrient::class, cascade:["persist", "remove"], orphanRemoval:true)]
    #[Groups(['Recipe'])]
    private Collection $nutrients;

    #[ORM\OneToOne(mappedBy:"recipe", targetEntity:Rating::class, cascade:["persist", "remove"])]
    #[Groups(['Recipe'])]
    private ?Rating $rating = null;
    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
        $this->steps = new ArrayCollection();
        $this->nutrients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getNumberDiner(): ?int
    {
        return $this->numberDiner;
    }

    public function setNumberDiner(int $numberDiner): self
    {
        $this->numberDiner = $numberDiner;

        return $this;
    }

    /**
     * @return Collection|Ingredient[]
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients[] = $ingredient;
            $ingredient->setRecipe($this);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): self
    {
        if ($this->ingredients->removeElement($ingredient)) {
            // set the owning side to null (unless already changed)
            if ($ingredient->getRecipe() === $this) {
                $ingredient->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Step[]
     */
    public function getSteps(): Collection
    {
        return $this->steps;
    }

    public function addStep(Step $step): self
    {
        if (!$this->steps->contains($step)) {
            $this->steps[] = $step;
            $step->setRecipe($this);
        }

        return $this;
    }

    public function removeStep(Step $step): self
    {
        if ($this->steps->removeElement($step)) {
            if ($step->getRecipe() === $this) {
                $step->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Nutrient[]
     */
    public function getNutrients(): Collection
    {
        return $this->nutrients;
    }

    public function addNutrient(Nutrient $nutrient): self
    {
        if (!$this->nutrients->contains($nutrient)) {
            $this->nutrients[] = $nutrient;
            $nutrient->setRecipe($this);
        }

        return $this;
    }

    public function removeNutrient(Nutrient $nutrient): self
    {
        if ($this->nutrients->removeElement($nutrient)) {
            if ($nutrient->getRecipe() === $this) {
                $nutrient->setRecipe(null);
            }
        }

        return $this;
    }

    public function getRating(): ?Rating
    {
        return $this->rating;
    }

    public function setRating(?Rating $rating): self
    {
        // unset the owning side of the relation if necessary
        if ($rating === null && $this->rating !== null) {
            $this->rating->setRecipe(null);
        }

        // set the owning side of the relation if necessary
        if ($rating !== null && $rating->getRecipe() !== $this) {
            $rating->setRecipe($this);
        }

        $this->rating = $rating;

        return $this;
    }
}
