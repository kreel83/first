<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Goutte\Client;

class LivreController extends AbstractController
{
    /**
     * @Route ("/react/livre/{slug}", name="reactLivre")
     * @param $slug
     * @return Response
     */
    public function reactdisplay($slug) {
        $client = new Client();
        $url = "https://www.livraddict.com/biblio/livre/".$slug.'.html';
        $crawler = $client->request('GET', $url);
        $params = array();
        $params['description'] = $this->treat($crawler->filter('#synopsis')->extract(array("_text")));
        $params['titre'] = $crawler->filter('.page-title>h1')->text();
        $params['genre'] = $crawler->filter('.sidebar-tags>li')->first()->filter('a')->extract(array("_text"))[0];
        $params['auteur'] = $crawler->filter('.page-title>a')->text();
        $param = $crawler->filter(".editionBlock>.editionBlock_infos>p")->extract(array('_text'));
        $i = -1;
        do {
            $i++;
        } while (strpos($param[$i],'min') !== false );
        $param = $crawler->filter(".editionBlock>.editionBlock_infos>p")->eq($i)->text();
        $params['couverture'] = $crawler->filter('.editionBlock>.editionBlock_cover>a')->eq($i)->extract(array("href"))[0];
        $exp = explode(' | ',$param);
        $params['isbn'] ="";
        $params['pages'] ="";
        $params['dateSortie'] ="";
        $google = 'q='.str_replace('-','+', $slug);
        $file = $this->recherche($google);
        $params['id'] = $file->items[0]->id;
        $params['dateSortie'] = $file->items[0]->volumeInfo->publishedDate;
        foreach ($exp as $item) {
            if (strpos($item, 'ISBN') !== false)
            { $params['isbn'] = explode(' : ',$item)[1]; }
            elseif ((strpos($item, 'pages') !== false))
            {
                $params['pages'] = explode(' ',$item)[0];
            }
            elseif ((strpos($item, 'Sortie') !== false)) {
                $params['dateSortie'] = explode(' : ',$item)[1];
            }
        }
        return new Response(json_encode($params));
    }


    private function recherche($q)
    {
        $url = "https://www.googleapis.com/books/v1/volumes?$q&printType=books&projection=lite&maxResults=40&langRestrict=Fr";
        $b = file_get_contents($url);
        return json_decode($b);
    }



    private function treat($r) {
        $a = preg_split('/\n/', $r[0]);
        $desc = "";
        for ($i=17; $i<sizeof($a);$i++) {
            $desc .= '<p>'.$a[$i].'</p>';
        }
        return $desc;
    }


    /**
     * @Route ("/display/{slug}", name="displayLivre")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function display($slug) {
        return $this->render('livre/display.html.twig', [
            'controller_name' => 'LivreController',
            "slug" => $slug
        ]);
    }

    /**
     * @Route("/livre/{slug}", name="livre")
     */
    public function index($slug)
    {
        $client = new Client();
        $r = [];
        $url = "https://www.livraddict.com/biblio/livre/".$slug.'.html';
        $crawler = $client->request('GET', $url);
        $params = array();
        $params['description'] = $this->treat($crawler->filter('#synopsis')->extract(array("_text")));

        $params['genre'] = $crawler->filter('.sidebar-tags>li')->first()->filter('a')->extract(array("_text"))[0];
        $params['auteur'] = $crawler->filter('.page-title>a')->text();
        $param = $crawler->filter(".editionBlock>.editionBlock_infos>p")->extract(array('_text'));
        $i = -1;
        do {
            $i++;
        } while (strpos($param[$i],'min') !== false );
        $param = $crawler->filter(".editionBlock>.editionBlock_infos>p")->eq($i)->text();
        $params['couverture'] = $crawler->filter('.editionBlock>.editionBlock_cover>a')->eq($i)->extract(array("href"))[0];
        $exp = explode(' | ',$param);
        $params['isbn'] ="";
        $params['pages'] ="";
        $params['dateSortie'] ="";

        $google = 'q='.str_replace('-','+', $slug);
        $file = $this->recherche($google);
        $params['id'] = $file->items[0]->id;
        $params['dateSortie'] = $file->items[0]->volumeInfo->publishedDate;

        foreach ($exp as $item) {

            if (strpos($item, 'ISBN') !== false)
            { $params['isbn'] = explode(' : ',$item)[1]; }
            elseif ((strpos($item, 'pages') !== false))
            {
                $params['pages'] = explode(' ',$item)[0];
            }
            elseif ((strpos($item, 'Sortie') !== false)) {
                $params['dateSortie'] = explode(' : ',$item)[1];
            }

        }

        return $this->render('livre/index.html.twig', [
            'controller_name' => 'LivreController',
            "params" => $params
        ]);
    }
}
