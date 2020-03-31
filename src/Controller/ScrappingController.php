<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Goutte\Client;

class ScrappingController extends AbstractController
{
    /**
     * @Route("/scrapping", name="scrapping")
     */
    public function index()
    {
        $client = new Client();
        $crawler = $client->request('GET',"https://www.livraddict.com/search.php?t=soif");


        $crawler->filter('.perfect_search ul li h3')->each(function($node) {
            dump(preg_replace("#\t|\r#","",$node->filter()->html()));
    });

        return $this->render('scrapping/index.html.twig', [
            'controller_name' => 'ScrappingController',

        ]);
    }
}
