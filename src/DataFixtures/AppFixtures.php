<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends BaseFixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        // $product = new Product();
        // $manager->persist($product);

        for ($i=1; $i<=10; $i++) {
            $cat = new Category();

            $cat->setName($faker->name);
            $cat->setContent('ttt');
            $manager->persist($cat);
            for ($j=1; $j<=10; $j++) {
                $book = new Book();
                $book->setTitre($faker->sentence);
                $book->setDescription($faker->paragraph);
                $book->setAuthor($faker->name);
                $book->setCategory($cat);
                $manager->persist($book);
            }
        }
        $manager->flush();
    }
}
