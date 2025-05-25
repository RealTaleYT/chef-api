<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\Nutrient;
use App\Entity\NutrientType;
use App\Entity\Ingredient;
use App\Entity\Step;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/recipes')]
class RecipeController extends AbstractController
{
    private EntityManagerInterface $em;
    private SerializerInterface $serializer;

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->serializer = $serializer;
    }

    #[Route('', methods: ['GET'])]
    public function list(Request $request): Response
    {
        $minCalories = $request->query->getInt('minCalories', 0);
        $maxCalories = $request->query->getInt('maxCalories', 9000);

        $repo = $this->em->getRepository(Recipe::class);
        $qb = $repo->createQueryBuilder('r')
            ->leftJoin('r.nutrients', 'n')
            ->leftJoin('n.type', 'nt')
            ->addSelect('n', 'nt')
            ->groupBy('r.id');

        if ($request->query->has('minCalories') || $request->query->has('maxCalories')) {
            if ($request->query->has('minCalories')) {
                $qb->having('SUM(CASE WHEN nt.name = :calName THEN n.quantity ELSE 0 END) >= :minCalories')
                   ->setParameter('minCalories', $minCalories);
            }
            if ($request->query->has('maxCalories')) {
                if ($qb->getDQLPart('having')) {
                    $qb->andHaving('SUM(CASE WHEN nt.name = :calName THEN n.quantity ELSE 0 END) <= :maxCalories');
                } else {
                    $qb->having('SUM(CASE WHEN nt.name = :calName THEN n.quantity ELSE 0 END) <= :maxCalories');
                }
                $qb->setParameter('maxCalories', $maxCalories);
            }
            $qb->setParameter('calName', 'Calories');
        }

        $recipes = $qb->getQuery()->getResult();

        $json = $this->serializer->serialize($recipes, 'json', ['groups' => ['Recipe']]);
        return new Response($json, 200, ['Content-Type' => 'application/json']);
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        try {
            $recipe = new Recipe();
            $recipe->setTitle($data['title'] ?? null);
            $recipe->setNumberDiner($data['number-diner'] ?? 0);

            // Ingredientes
            foreach ($data['ingredients'] ?? [] as $ingredientData) {
                $ingredient = new Ingredient();
                $ingredient->setName($ingredientData['name'] ?? '');
                $ingredient->setQuantity($ingredientData['quantity'] ?? 0);
                $ingredient->setUnit($ingredientData['unit'] ?? '');
                $ingredient->setRecipe($recipe);
                $recipe->addIngredient($ingredient);
            }

            // Pasos
            foreach ($data['steps'] ?? [] as $stepData) {
                $step = new Step();
                $step->setstepOrder($stepData['stepOrder'] ?? 0);
                $step->setDescription($stepData['description'] ?? '');
                $step->setRecipe($recipe);
                $recipe->addStep($step);
            }

            // Nutrientes
            foreach ($data['nutrients'] ?? [] as $nutrientData) {
                if (!isset($nutrientData['type-id'])) {
                    throw new \Exception("Nutrient missing 'type-id'");
                }

                $nutrientType = $this->em->getRepository(NutrientType::class)->find($nutrientData['type-id']);
                if (!$nutrientType) {
                    throw new \Exception("NutrientType id {$nutrientData['type-id']} not found");
                }

                $nutrient = new Nutrient();
                $nutrient->setType($nutrientType);
                $nutrient->setQuantity($nutrientData['quantity'] ?? 0);
                $nutrient->setRecipe($recipe);
                $recipe->addNutrient($nutrient);
            }

            $this->em->persist($recipe);
            $this->em->flush();

            $json = $this->serializer->serialize($recipe, 'json', ['groups' => ['Recipe']]);
            return new Response($json, 201, ['Content-Type' => 'application/json']);
        } catch (\Exception $e) {
            return new Response(json_encode(['error' => 'Invalid data: ' . $e->getMessage()]), 400, ['Content-Type' => 'application/json']);
        }
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(int $id): Response
    {
        $recipe = $this->em->getRepository(Recipe::class)->find($id);

        if (!$recipe) {
            return new Response(json_encode(['error' => 'Recipe not found']), 404, ['Content-Type' => 'application/json']);
        }

        $json = $this->serializer->serialize($recipe, 'json', ['groups' => ['Recipe']]);
        return new Response($json, 200, ['Content-Type' => 'application/json']);
    }
}
