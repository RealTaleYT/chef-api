<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
class Rating
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    #[Groups(['Recipe'])]
    private ?int $id = null;

    #[ORM\Column(type:"integer")]
    #[Groups(['Recipe'])]
    private ?int $numberVotes = null;

    #[ORM\Column(type:"float")]
    #[Groups(['Recipe'])]
    private ?float $ratingAvg = null;

    #[ORM\OneToOne(targetEntity:Recipe::class, inversedBy:"rating")]
    #[ORM\JoinColumn(nullable:false)]
    private ?Recipe $recipe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberVotes(): ?int
    {
        return $this->numberVotes;
    }

    public function setNumberVotes(int $numberVotes): self
    {
        $this->numberVotes = $numberVotes;

        return $this;
    }

    public function getRatingAvg(): ?float
    {
        return $this->ratingAvg;
    }

    public function setRatingAvg(float $ratingAvg): self
    {
        $this->ratingAvg = $ratingAvg;

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
