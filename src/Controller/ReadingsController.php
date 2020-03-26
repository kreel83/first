<?php

namespace App\Controller;

use App\Entity\Book;

use App\Entity\Category;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;

use Doctrine\ORM\Repository\RepositoryFactory;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ReadingsController extends AbstractController
{
    /**
     * @Route("ajaxCall", name="ajaxCall")
     * @param $request
     * @return JsonResponse
     */
    public function ajaxcall(Request $request, EntityManagerInterface $manager) {
        $repo = $this->getDoctrine()->getRepository(Book::class);
        $id = $request->get('id');
        //$books = $repo->findBy(["category" => $id]);

        $q = $manager->createQueryBuilder();
        $books = $q->select('b.titre',"b.author","b.description")
            ->from(Book::class, 'b')
            ->where('b.category = :cat')
            ->setParameter('cat', $id)
            ->getQuery()
            ->execute();


        $encoder = [new JsonEncoder()];
        $normalizer = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizer, $encoder);
        $jsonContent = $serializer->serialize($books, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new JsonResponse($books);
    }




    /**
     * @Route("/readings", name="readings")
     */

    public function index(BookRepository $repobook, CategoryRepository $repocat, EntityManagerInterface $manager) {
        $encoder = [new JsonEncoder()];
        $normalizer = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizer, $encoder);

        $first=$repobook->findAll()[0];
        $id = $first->getCategory()->getId();

        //$books = $repobook->findBy(["category" => $id]);
        $q = $manager->createQueryBuilder();
        $books = $q->select('b.titre',"b.author","b.description")
            ->from(Book::class, 'b')
            ->getQuery()
            ->execute();


        dump($books);
        $categories = $repocat->findAll();


        return $this->render('readings/index.html.twig', [
            'controller_name' => 'ReadingsController',
            'books' => $books,
            'categories' => $categories

        ]);
    }

    /**
     * @Route("/createBook", name="book_create")
     * @param Request $request
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createBook(Request $request, EntityManagerInterface $manager)
    {
        $book = new Book();
        $form = $this->createFormBuilder($book)
            ->add('titre')
            ->add('description')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => "name"
            ])
            ->add('author')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($request->request->get('description'));
            $manager->persist($book);
            $manager->flush();
        }

        return $this->render('readings/index.html.twig', [
            'controller_name' => 'ReadingsController',
            'form' => $form->createView()
        ]);
    }
}
