<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="security_registration")
     * @param Request $request -> contient les infos en provenance du formulaire -> requete HTTP
     * @param ObjectManager $userManager
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request, ObjectManager $userManager, UserPasswordEncoderInterface $encoder) {

        $user = new User();

        // Crée le formulaire -> seulement pour les essais avant intégration de VueJS
        // Passage du User en paramètre pour le lier au formulaire
        $form = $this->createForm(RegistrationType::class, $user);

        // Cette partie sera à modifiée après integration de vueJs
        $form->handleRequest($request);

        // Vérif submit
        if ($form->isSubmitted() && $form->isValid()) {

            // encodage du password -> utilisation du composant security de Symfony
            // pour fonctionner, ajouter l'encoder au niveau du fichier config/security.yaml
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            // Sauvegarde dans la BDD
            $userManager->persist($user);
            $userManager->flush();

            return $this->redirectToRoute('security_login');
        }

        // Cette partie sera à modifiée après intégration de vueJs
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="security_login")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login() {

        // pour fonctionner, besoin d'ajouter un provider dans le fichier security.yaml
        // dans ce cas le providers in-database à été ajouté
        // c'est celui-vi qui se chargera de la connexion

        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout() {

    }

}















