<?php
/**
 * Created by PhpStorm.
 * User: stephan
 * Date: 01/03/19
 * Time: 14:27
 */

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordController extends AbstractController
{
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $encoder) {
        if ($request->isMethd('POST')) {
            $entityManager = $this->getDoctrine()->getManager();

            $user = $entityManager->getRepository(User::class)->findOneByResetToken($token);

            if ($user === null) {
                // define the message flash and add in response return
                return $this->redirectToRoute('security_login');
            }

            $user->setResetToken(null);
            $hash = $encoder->encodePassword($user, $request->getPassword());
            $user->setPassword($hash);
            $entityManager->flush();

            return $this->redirectToRoute('forgot_password');

        } else {
            return $this->render('security_login');
        }
    }
}