<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use App\Entity\Ingredient;
use App\Entity\Step;
use App\Entity\NutrientType;
use App\Entity\Nutrient;
use App\Entity\Rating;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Crear NutrientTypes básicos
        $calories = new NutrientType();
        $calories->setName('Calories');
        $calories->setUnit('kcal');
        $manager->persist($calories);

        $proteins = new NutrientType();
        $proteins->setName('Proteins');
        $proteins->setUnit('gr');
        $manager->persist($proteins);

        $fats = new NutrientType();
        $fats->setName('Saturated Fat');
        $fats->setUnit('gr');
        $manager->persist($fats);

        $carbs = new NutrientType();
        $carbs->setName('Carbs');
        $carbs->setUnit('gr');
        $manager->persist($carbs);

        // Crear Recipe ejemplo
        $recipe = new Recipe();
        $recipe->setTitle('Tiramisu');
        $recipe->setNumberDiner(4);

        // Ingredientes
        $ingredient1 = new Ingredient();
        $ingredient1->setName('Eggs');
        $ingredient1->setQuantity(4);
        $ingredient1->setUnit('units');
        $ingredient1->setRecipe($recipe);
        $manager->persist($ingredient1);

        $ingredient2 = new Ingredient();
        $ingredient2->setName('Sugar');
        $ingredient2->setQuantity(250);
        $ingredient2->setUnit('gr');
        $ingredient2->setRecipe($recipe);
        $manager->persist($ingredient2);

        // Pasos
        $step1 = new Step();
        $step1->setstepOrder(1);
        $step1->setDescription('Mix the eggs with the sugar.');
        $step1->setRecipe($recipe);
        $manager->persist($step1);

        $step2 = new Step();
        $step2->setstepOrder(2);
        $step2->setDescription('Add coffee.');
        $step2->setRecipe($recipe);
        $manager->persist($step2);

        // Nutrientes
        $nutrientCalories = new Nutrient();
        $nutrientCalories->setType($calories);
        $nutrientCalories->setQuantity(400);
        $nutrientCalories->setRecipe($recipe);
        $manager->persist($nutrientCalories);

        $nutrientProteins = new Nutrient();
        $nutrientProteins->setType($proteins);
        $nutrientProteins->setQuantity(7);
        $nutrientProteins->setRecipe($recipe);
        $manager->persist($nutrientProteins);

        // Rating
        $rating = new Rating();
        $rating->setNumberVotes(5);
        $rating->setRatingAvg(4.5);
        $recipe->setRating($rating);
        $manager->persist($rating);

        $manager->persist($recipe);
        $manager->flush();
    }
}
