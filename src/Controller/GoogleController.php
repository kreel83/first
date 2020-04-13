<?php

namespace App\Controller;


use App\Entity\Auteur;
use App\Entity\Categorie;
use App\Entity\Livre;
use App\Repository\LivreRepository;
use Doctrine\ORM\Repository\RepositoryFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use JBarbin\GoogleBooksBundle\GoogleAPI\Query;
use Goutte\Client;

class GoogleController extends AbstractController
{
    /**
     * @Route ("/accueil", name="accueil")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function test()
    {
        return $this->render('accueil.html.twig');
    }

    /**
     * @Route ("google/ajax", name="ajax")
     * @return string
     */
    public function ajaxRender()
    {
        $b = ["title" => "titre", "author" => "auteur", "description" => "description"];
        $query = "q=autant";
        $books = $this->recherhe($query);
        $details = [];
        foreach ($books->items as $key => $book) {
            $det = array();
            $det['titre'] = $book->volumeInfo->title;
            isset($book->volumeInfo->authors[0]) ? $det['author'] = $book->volumeInfo->authors[0] : $det['author'] = "";
            isset($book->volumeInfo->description) ? $det['description'] = $book->volumeInfo->description : $det['description'] = "";
            //$det['description'] = $book->volumeInfo->description;
            array_push($details, $det);
        }
        return new Response(json_encode($details));
    }



    /**
     * @Route ("google/listeLivres", name="listeLivres")
     * @param Request $request
     * @return Response
     */
    public function listeLivre(Request $request) {

        $url =  "https://livraddict.com".$request->request->get('link');
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $r = $crawler->filter('#bookAuthor>tbody>tr>td')->filter("a")->extract(array("_text","href"));

        return new Response(json_encode([

            'link' => $r
        ]));
    }


    /**
     * @Route("/google/rechercheLivreaddict/{titre}/{lapage}", name="rechercheLivraddict")
     * @param $titre , $lapage
     * @return array
     */
    public function rechercheLivreaddict($titre, $lapage)
    {
        $client = new Client();
        $r = [];
        $url = "https://www.livraddict.com/search.php?page=$lapage&t=$titre";
        $crawler = $client->request('GET', $url);
        $rr = $crawler->filter('.listing_recherche>li');
        $r['lien'] = $rr->filter('div>a')->extract(array('href'));
        $r['imageurl'] = $rr->filter('div>a>img')->extract(array('src'));
        $r['auteur'] = $rr->filter('.item_infos>p>a')->extract("_text");
        $r['genre'] = $rr->filter('.item_infos>.genre')->extract("_text");

        $books = [];
        $nb = sizeof($r['lien']);
        for ($i = 0; $i < $nb; $i++) {
            $books[$i]['titre'] = str_replace('-',' ',str_replace('.html','',explode('/',$r['lien'][$i])[3]));
            $books[$i]['lien'] = $r['lien'][$i];
            $books[$i]['imageurl'] = $r['imageurl'][$i];
            $books[$i]['auteur'] = $r['auteur'][$i];
            $books[$i]['genre'] = $r['genre'][$i];
        }

        $authors = [];
        $auth = $crawler->filter('#tab_auteurs>ul');
        $a['auteur'] = $auth->filter("li>a")->extract(array("_text"));
        $a['link'] = $auth->filter("li>a")->extract(array("href"));
        $nb = sizeof($a['auteur']);
        for ($i = 0; $i < $nb; $i++) {
            $authors[$i]['auteur'] = $a['auteur'][$i];
            $authors[$i]['link'] = $a['link'][$i];
            $url = "https://www.livraddict.com/".$a['link'][$i];
            $c = new Client();
            $crawler = $c->request('GET', $url);
            $authors[$i]['photo'] = $crawler->filter(".profile-userpic>img")->extract(array("src"));
            ($authors[$i]['photo'] == []) ? $authors[$i]['photo'] = "none" : $authors[$i]['photo'] = $authors[$i]['photo'][0];
        }
        return new Response(json_encode(["books" => $books, "authors" => $authors, "nbBook" => $this->nb($titre)]));
    }

    /**
     * @Route("/google/searchMyTable", name="searchMyTable")
     * @param Request $request
     */
    public function searchIntoTable(Request $request) {
        dump('search');
        $repo = $this->getDoctrine()->getRepository(Livre::class);
        $aut = $this->getDoctrine()->getRepository(Auteur::class);
        $livres = $repo->createQueryBuilder('o')->where("o.titre LIKE :titre")->setParameter('titre', '%'.$request->request->get('titre').'%')->getQuery()->getResult();
        $auteurs = $aut->createQueryBuilder('o')->where("o.nom LIKE :auteur")->setParameter('auteur', '%'.$request->request->get('titre').'%')->getQuery()->getResult();
        for ($i=0; $i<sizeof($auteurs); $i++) {
            $auteurs[$i]->photo = "none";
        }
        dump($livres);
        return $this->render('google/livreAddict.html.twig', [
            'books' => $livres,
            'authors' => $auteurs,
            'nblivres' => sizeof($livres),
            'nbpages' => (int) floor(sizeof($livres)/10) + 1,
            'requete' => $request->request->get('titre')

        ]);
    }



    /**
     * @Route("/google/search", name="google_search")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function search(Request $request)
    {
        $cat = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        $books = [];
        $r = [];
        if (sizeof($request->request) > 0) {
            $r['titre'] = trim(str_replace(' ', '+', $request->request->get('titre')));
            $r['auteur'] = $request->request->get('auteur');
            if ($request->request->get('titre') != "") {
                $urlParams = "q=" . str_replace(' ', '+', trim($request->request->get('titre')));
            } else {
                $urlParams = 'q=';
            }
            if ($request->request->get('auteur') != "") {
                $urlParams .= '+inauthor:' . str_replace(' ', '+', trim($request->request->get('auteur')));
            }
            if ($request->request->get('valide') == "google") {
                $books = $this->recherche($urlParams);
            } else {
                $books = $this->rechercheLivreaddict($r['titre'], 1);


                $nb = $this->nb($r['titre']);
                $books = json_decode($books->getContent());
dump($books->authors);
                return $this->render('google/livreAddict.html.twig', [
                    'books' => $books->books,
                    'authors' => $books->authors,
                    'nblivres' => $nb,
                    'nbpages' => (int) floor($nb/10) + 1,
                    'cat' => $cat,
                    'requete' => $r['titre']
                ]);
            }
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
        $query = "q=autant";
        $books = $this->recherche($query);
        return $this->render('google/index.html.twig', [
            'controller_name' => 'GoogleController',
            'books' => $books->items
        ]);
    }


    private function recherche($q)
    {
        $url = "https://www.googleapis.com/books/v1/volumes?$q&printType=books&projection=lite&maxResults=40&langRestrict=Fr";
        $b = file_get_contents($url);
        return json_decode($b);
    }


    private function nb($p)
    {
        $client = new Client();
        $url = "https://www.livraddict.com/search.php?t=$p";
        $crawler = $client->request('GET', $url);
        $rr = $crawler->filter('#searchnav li')->first()->text();
        if ($rr == []) {
            return 999;
        }
        $match = array();
        preg_match('/\d+/',$rr, $match);
        //dump($match);
        return intval($match[0]);
    }

}
