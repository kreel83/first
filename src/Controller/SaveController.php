<?php

namespace App\Controller;


use App\Entity\Auteur;
use App\Entity\Lecture;
use App\Entity\Livre;
use App\Repository\AuteurRepository;
use App\Repository\LectureRepository;
use App\Repository\LivreRepository;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class SaveController extends AbstractController
{


    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/add/la", name="add_la")
     * @return Response
     */
    public function AddToLA($book, EntityManagerInterface $manager)
    {
        $lec = $this->getDoctrine()->getRepository(Lecture::class);
        $l = $this->getDoctrine()->getRepository(Livre::class);
        $livre = $l->findOneBy(['googleid' => $book]);

        if ($lec->findOneBy(["livre" => $livre])) {

            $lecture = $lec->findOneBy(["livre" => $livre]);
            $lecture->setStatut('la');
            $manager->persist($lecture);
            $manager->flush();

        } else {
            dump("coucou");
            $lecture = new Lecture();
            $lecture->setLivreId($livre);
            $lecture->setDebutLecture(Carbon::now());
            $lecture->setUserId($this->security->getUser());
            $lecture->setStatut('la');

            $manager->persist($lecture);
            $manager->flush();

        }

        return new Response($book);
    }

    /**
     * @Route("/add/wl", name="add_wl")
     * @return Response
     */
    public function AddToWL($book, EntityManagerInterface $manager)
    {
        $lec = $this->getDoctrine()->getRepository(Lecture::class);
        $l = $this->getDoctrine()->getRepository(Livre::class);
        $livre = $l->findOneBy(['googleid' => $book]);

        if ($lec->findOneBy(["livre" => $livre])) {

            $lecture = $lec->findOneBy(["livre" => $livre]);
            $lecture->setStatut('wl');
            $manager->persist($lecture);
            $manager->flush();

        } else {
            dump("coucou");
            $lecture = new Lecture();
            $lecture->setLivreId($livre);
            $lecture->setUserId($this->security->getUser());
            $lecture->setStatut('wl');

            $manager->persist($lecture);
            $manager->flush();

        }

        return new Response($book);
    }


    /**
     * @Route("/add/ar", name="add_ar")
     * @return Response
     */
    public function AddToAR($book, $date, EntityManagerInterface $manager)
    {

        $l = $this->getDoctrine()->getRepository(Livre::class);
        $livre = $l->findOneBy(['googleid' => $book]);
            $lecture = new Lecture();
            $lecture->setLivreId($livre);
            $lecture->setUserId($this->security->getUser());
            $lecture->setDebutLecture($date);
            $lecture->setStatut('ar');

            $manager->persist($lecture);
            $manager->flush();



        return new Response($book);
    }

    /**
     * @Route("/add/arFromLA", name="add_ar_to_la")
     * @return Response
     */
    public function AddToARFromLA($book, $params, EntityManagerInterface $manager)
    {

        $l = $this->getDoctrine()->getRepository(Lecture::class);
        $lecture = $l->find($book);


        $lecture->setUserId($this->security->getUser());
        $lecture->setDecouverte($params['decouverte']);
        $lecture->setFinLecture($params['fin']);
        $lecture->setIndice($params['indice']);
        $lecture->setStatut('ar');

        $manager->persist($lecture);
        $manager->flush();



        return new Response($book);
    }



    /**
     * @Route("/add/wish", name="add_wish")
     */
    public function saveWL(EntityManagerInterface $manager, $book)
    {
        $aut = $this->getDoctrine()->getRepository(Auteur::class);
        if (!$aut->findOneBy(['nom' => $book['auteur']])) {

            $auteur = new Auteur();
            $auteur->setNom($book['auteur']);
            $manager->persist($auteur);
            $manager->flush();

        } else {

            $auteur = $aut->findOneBy(['nom' => $book['auteur']]);

        }

        $repo = $this->getDoctrine()->getRepository(Livre::class);
        if (!$repo->findOneBy(['googleid' => $book['id']])) {

            $livre = new Livre();
            $livre->setTitre($book["titre"])
                ->setDescription($book['description'])
                ->setAuteur($auteur)
                ->setGenre($book['categorie'])
                ->setImageurl($book['couverture'])
                ->setGoogleid($book['id'])
                ->setIsbn($book['isbn']);
            $manager->persist($livre);
            $manager->flush();
            return new Response("done");
        }


        return new Response("dejà");
    }
}
