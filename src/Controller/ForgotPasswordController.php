<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class ForgotPasswordController extends AbstractController
{
    /**
     * @Route("/forgotPassword", name="forgot_password")
     */
    public function index()
    {
        return $this->render('security/forgotPassword.html.twig', [
            'controller_name' => 'ForgotPasswordController',
        ]);
    }

    /**
     * @Route("/forgotten_password", name="forgotPassword")
     * @param Request $request
     * @param ObjectManager $userManager
     * @param UserPasswordEncoderInterface $encoder
     * @param \Swift_Mailer $mailer
     * @param TokenGeneratorInterface $tokenGenerator
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function forgottenPassword(Request $request,
                                      ObjectManager $userManager,
                                      UserPasswordEncoderInterface $encoder,
                                      \Swift_Mailer $mailer,
                                      TokenGeneratorInterface $tokenGenerator) {

        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');

            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->findOneByEmail($email);

            if ($user === null) {
                // add message flash message in json response
                return $this->redirectToRoute('security_login');
            }

            // add field token in user Entity
            $token = $tokenGenerator->generateToken();

            try {
                $user->setResetToken($token);
                $entityManager->flush();
            } catch (\Exception $e) {
                // add message flash in json response
                return $this->redirectToRoute('security_login');
            }

            $url = $this->generateUrl('security/forgotPassword', array('token'=> $token), UrlGeneratorInterface::ABSOLUTE_URL);

            $message = (new \Swift_Message('Forgot Password'))
                ->setFrom('s.gaudefroy@orange.fr')
                ->setTo($user->getEmail())
                ->setBody(
                    "blablabla, voici le token pour reseter votre mot de passe : " . $url,
                    'text/html'
                );

            $mailer->send($message);

            //add message flash pour prevenir de l'envoi de l'email
            return $this->redirectToRoute('login');
        }

        return $this->render('security/forgotPassword.html.twig');

    }
}
