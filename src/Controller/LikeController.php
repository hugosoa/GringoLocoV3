<?php

namespace App\Controller;

use App\Entity\Cocktail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class LikeController extends AbstractController
{
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
