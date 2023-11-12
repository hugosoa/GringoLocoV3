<?php

namespace App\Controller;

use App\Entity\Cocktail;
use App\Entity\Ingredient;
use App\Repository\CocktailRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CardController extends AbstractController
{
    #[Route('/card', name: 'app_card')]
    public function index(CocktailRepository $cocktailRepository): Response
    {



        $cocktail = $cocktailRepository->findAll();
        // dd($cocktail);
        return $this->render('card/index.html.twig', [
            'cocktails' => $cocktail,
        ]);
    }

    #[Route('/like/cocktail/{id)', name: 'app_like_cocktail')]
    public function like(Cocktail $cocktail, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();

        if ($cocktail->isLikedByUser($user)) {
            $cocktail->removeLikeCocktail($user);
            $manager->flush();

            return $this->json(['message' => 'Le like a été supprimé']);
        }

        $cocktail->addLikeCocktail($user);
        $manager->flush();

        return $this->json(['message' => 'Le like a été ajouté']);
    }
}
