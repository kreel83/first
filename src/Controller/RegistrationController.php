<?php

namespace App\Controller;

use App\Form\UserType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends Controller
{
    /**
     * @Route("/Register", name="user_registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $user->setDateCreated(new \Datetime());
        $random = rtrim(strtr(base64_encode(random_bytes(64)), '+/', '-_'), '=');
        $user->setResetPasswordToken($random);
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        dump($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();


            $request->getSession()->getFlashBag()->add('user-valide', 'Vous êtes bien inscrit ! Un email de validation vous a été envoyé.');
            return $this->redirectToRoute('accueil');
        }

        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );
    }


}