<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use App\Entity\Article;
use Vich\UploaderBundle\Entity\File;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private Generator $faker;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
        $users = [];

        $photos = [
            1 => [
                'name' => 'public/images/upload/Cocktail-Blue-Lagoon-Nischal-Kanishk-on-Unsplash.webp',
            ],
            2 => [
                'name' => 'Purple-rain-90edf70.jpg',
            ],
            3 => [
                'name' => 'Strawberry-Marg-c985252.jpg',
            ],
        ];

        for ($i = 0; $i < 10; $i++) {
            $user = new User;
            $user->setFirstName($this->faker->name());
            $user->setLastName($this->faker->name());
            $user->setPseudo($this->faker->word());
            $user->setEmail($this->faker->email());
            $user->setPassword($this->encoder->hashPassword($user, '123456'));

            $users[] = $user;
            $manager->persist($user);
        }



        for ($i = 0; $i < 10; $i++) {
            $article = new Article;
            $article->setAuthor($users[mt_rand(0, count($users) - 1)]);
            $article->setTitle($this->faker->sentence());
            $article->setContent($this->faker->paragraphs(3, true));

            $article->setImageSize(1000);
            $article->setImageName($photos[$this->faker->numberBetween(1, 3)]['name']);
            $manager->persist($article);
        }
        $manager->flush();
    }
}
