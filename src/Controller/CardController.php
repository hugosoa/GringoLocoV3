<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Repository\CocktailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    #[Route('/card', name: 'app_card')]
    public function index(CocktailRepository $cocktailRepository): Response
    {
        $cocktail = $cocktailRepository->findAll();
        return $this->render('card/index.html.twig', [
            'cocktails' => $cocktail,
        ]);
    }
}
