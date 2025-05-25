<?php
namespace App\Controller;

use App\Entity\NutrientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/nutrient-types')]
class NutrientTypeController extends AbstractController
{
    private $em;
    private $serializer;

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->serializer = $serializer;
    }

    #[Route('', methods: ['GET'])]
    public function list(): Response
    {
        $types = $this->em->getRepository(NutrientType::class)->findAll();

        $json = $this->serializer->serialize($types, 'json');
        return new Response($json, 200, ['Content-Type' => 'application/json']);
    }
}
