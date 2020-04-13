<?php

namespace App\Controller;

use App\Entity\Lecture;
use App\Entity\Livre;
use Carbon\Carbon;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class MyPageController extends AbstractController


{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/mapage", name="mapage")
     */
    public function index()
    {

        $livreRepo = $this->getDoctrine()->getRepository(Livre::class);
        $lectureRepo = $this->getDoctrine()->getRepository(Lecture::class);
        $meslecturesWL = $lectureRepo->findBy(['user' => $this->security->getUser(), "statut" => 'wl']);
        $meslecturesLA = $lectureRepo->findBy(['user' => $this->security->getUser(), "statut" => 'la']);
        $meslecturesAR = $lectureRepo->findBy(['user' => $this->security->getUser(), "statut" => 'ar'],["debutLecture" => "DESC"],10);

        return $this->render('my_page/index.html.twig', [
            'controller_name' => 'MyPageController',
            'lecturesWL' => $meslecturesWL,
            'lecturesLA' => $meslecturesLA,
            'lecturesAR' => $meslecturesAR
        ]);
    }

    /**
     * @Route("/mapage/changeStatut", name="changeStatut", methods={"POST"})
     * @param $attr
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function changeStatut(Request $request, EntityManagerInterface $manager) {
        $id = $request->request->get('wl_id');
        $statut = $request->request->get('wl_statut');


        $submit = $request->request->get('submit');
        $repo = $this->getDoctrine()->getRepository(Lecture::class);
        $lecture = $repo->find($id);
        if ($statut == "wl") {
            if ($submit == "supp") {
                $manager->remove($lecture);
                $manager->flush();
            } else {
                $lecture->setStatut('la');
                $manager->flush();
            }
        }
        if ($statut == 'ar') {

            $y = intval($request->request->get('annee'));
            $m = intval($request->request->get('mois'));
            $date = Carbon::createFromDate($y,$m,1);
            $this->forward('App\Controller\SaveController::AddToAR', [
                'book' => $id,
                'date' => $date
            ]);

        }

        return $this->redirectToRoute('mapage');
    }
}
