<?php

namespace App\Controller;

use App\Entity\Lecture;
use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LectureController extends AbstractController
{

    /**
     * @Route("/reading/save_note", name="saveNote", methods={"POST"})
     */
    public function save(Request $request) {
        $id = $request->request->get('id');
        $params['indice'] = 85.20;
        $params['fin'] = Carbon::now();
        $params['decouverte'] = 2;
        $r = $this->forward('App\Controller\SaveController::AddToARFromLA', [
            "book" => $id,
            "params" => $params

        ]);
        dump($r);
        return $this->redirectToRoute('mapage');
    }
    /**
     * @Route("/reading/{book}", name="lecture")
     */
    public function index($book)
    {
        $repo = $this->getDoctrine()->getRepository(Lecture::class);
        $lecture = $repo->find($book);
        return $this->render('lecture/index.html.twig', [
            'controller_name' => 'LectureController',
            'lecture' => $lecture
        ]);
    }


}
