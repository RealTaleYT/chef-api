<?php
namespace App\Controller;

use App\Entity\Recipe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/recipes/{recipeId}/rating/{rate}')]
class RatingController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('', methods: ['POST'])]
    public function addRating(int $recipeId, int $rate): Response
    {
        if ($rate < 0 || $rate > 5) {
            return $this->json(['error' => 'Rate must be between 0 and 5'], 400);
        }

        $recipe = $this->em->getRepository(Recipe::class)->find($recipeId);
        if (!$recipe) {
            return $this->json(['error' => 'Recipe not found'], 404);
        }

        $currentVotes = $recipe->getRating()?->getNumberVotes() ?? 0;
        $currentAvg = $recipe->getRating()?->getRatingAvg() ?? 0;

        $newVotes = $currentVotes + 1;
        $newAvg = (($currentAvg * $currentVotes) + $rate) / $newVotes;

        // Si no tiene Rating, crear uno
        $rating = $recipe->getRating();
        if (!$rating) {
            $rating = new \App\Entity\Rating();
            $recipe->setRating($rating);
        }

        $rating->setNumberVotes($newVotes);
        $rating->setRatingAvg($newAvg);

        $this->em->persist($rating);
        $this->em->flush();

        return $this->json($recipe, 200, [], ['groups' => ['Recipe']]);
    }
}
