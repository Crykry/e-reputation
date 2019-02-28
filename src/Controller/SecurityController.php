<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="security_registration")
     * @param Request $request -> contient les infos en provenance du formulaire -> requete HTTP
     * @param ObjectManager $userManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request, ObjectManager $userManager) {

        $user = new User();

        // Crée le formulaire -> seulement pour les essais avant intégration de VueJS
        // Passage du User en paramètre pour le lier au formulaire
        $form = $this->createForm(RegistrationType::class, $user);

        // Cette partie sera à modifiée après integration de vueJs
        $form->handleRequest($request);

        // Vérif submit et validation des données
        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarde dans la BDD
            $userManager->persist($user);
            $userManager->flush();
        }

        // Cette partie sera à modifiée après intégration de vueJs
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
