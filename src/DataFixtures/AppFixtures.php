<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Categorie;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Goutte\Client;

class AppFixtures extends BaseFixture
{
    public function load(ObjectManager $manager)
    {

        $client = new Client();
        $crawler = $client->request('GET', "https://www.livraddict.com/biblio/toplivres.php?g=Romans&year=&nbrevotes=100");
        $rr = $crawler->filter('#filtre_genre>option')->extract(array('value'));
        $rr = array_unique($rr);

        asort($rr);
        $rr = array_filter($rr, function ($el) {
            return  $el!="";
        });
        foreach ($rr as $r) {
            $categorie = new Categorie();
            $categorie->setNom($r);
            $categorie->setCouleur("");
            $manager->persist($categorie);
        }
        $manager->flush();
        $cat = new Categorie();

/*        $faker = Factory::create();
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
          yes  }
        }*/
        //$manager->flush();
    }
}
