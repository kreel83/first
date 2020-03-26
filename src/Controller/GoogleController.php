<?php

namespace App\Controller;


use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use JBarbin\GoogleBooksBundle\GoogleAPI\Query;

class GoogleController extends AbstractController
{
    /**
     * @Route ("/", name="test")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function test() {
        return $this->render('test.html.twig');
    }

    /**
     * @Route ("google/ajax", name="ajax")
     * @return string
     */
    public function ajaxRender() {
        $b = ["title" => "titre", "author" => "auteur", "description" => "description"];
        $query = "q=autant";
        $books = $this->recherhe($query);
        dump($books->items);
        return new \Symfony\Component\HttpFoundation\Response(json_encode($books->items));
    }



    private function recherhe($q) {
        $url = "https://www.googleapis.com/books/v1/volumes?$q&printType=books&projection=lite&maxResults=40&langRestrict=Fr";

        $b = file_get_contents($url);
        return json_decode($b);
    }


    /**
     * @Route("/google/search", name="google_search")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function search(Request $request) {
        $books = [];
        $r = [];
        if (sizeof($request->request) > 0) {
            $r['titre'] = $request->request->get('titre');
            $r['auteur']=  $request->request->get('auteur');
            if ($request->request->get('titre') != "") {
                $urlParams = "q=".str_replace(' ', '+', trim($request->request->get('titre')));
            } else {
                $urlParams='q=';
            }
            if ($request->request->get('auteur') != "") {
                $urlParams .= '+inauthor:'.str_replace(' ', '+', trim($request->request->get('auteur')));
            }
            $books = $this->recherhe($urlParams);

        }
        return $this->render('google/search.html.twig', [
            'books' => $books,
            'request' => $r
        ]);
    }


    /**
     * @Route("/google", name="google")
     */
    public function index()
    {
        $query = "autant";
        $books = $this->recherhe($query);

        return $this->render('google/index.html.twig', [
            'controller_name' => 'GoogleController',
            'books' => $books->items
        ]);
    }
}
