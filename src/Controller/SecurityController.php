<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class SecurityController extends AbstractController
{
    /**
     * @Route("/Login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/Logout", name="logout")
     */
    public function logout()
    {

        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/Forgotten_password", name="forgotten_password")
     *
     */
    public function ForgottenPassword( Request $request,
                                       UserPasswordEncoderInterface $encoder,
                                       \Swift_Mailer $mailer
                                    ){
        if ($request->isMethod('POST')) {
 
            $email = $request->request->get('email');
 
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->findOneByEmail($email);

            /* @var $user User */
 
            if ($user === null) {
               // $request->getSession()->getFlashBag()->add('user-valide', 'Vous êtes bien inscrit ! Un email de validation vous a été envoyé.');
                $this->addFlash('danger', 'Cet email n\'est pas valide');
                return $this->render('security/forgotten_password.html.twig');
            }
            $token = $random = rtrim(strtr(base64_encode(random_bytes(64)), '+/', '-_'), '=');
 
            try{
                $user->setResetPasswordToken($token);
                $em->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', $e->getMessage());
                return $this->render('security/forgotten_password.html.twig');
            }
 
            $url = $this->generateUrl('reset_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
 
            $message = (new \Swift_Message('Forgot Password'))
                ->setFrom('no-reply.tropimangame@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    "Click on the following link to reset your password: " . $url,
                    'text/html'
                );
 
            $mailer->send($message);
 
            $this->addFlash('notice', 'Email envoyé');
 
            return $this->redirectToRoute('forgotten_password');
        }
 
        return $this->render('security/forgotten_password.html.twig');
 
    }
    /**
     * @Route("/reset_password/{token}", name="reset_password")
     *
     */
    public function ResetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {
 
        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
 
            $user = $em->getRepository(User::class)->findOneByResetToken($token);
 
            if ($user === null) {
                $this->addFlash('danger', 'Impossible de mettre à jour le mot de passe');
                return $this->render('security/reset_password.html.twig', ['token' => $token]);
            }
 
            $user->setResetToken(null);
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            $em->flush();
 
            $this->addFlash('notice', 'Mot de passe mis à jour');
 
            return $this->redirectToRoute('home');
        }else {
 
            return $this->render('security/reset_password.html.twig', ['token' => $token]);
        }
 
    }    
}
