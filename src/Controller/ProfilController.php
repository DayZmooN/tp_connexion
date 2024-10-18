<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/profil', name: 'profil.')]
class ProfilController extends AbstractController
{

    #[Route('', name: 'index')]
    public function index(): Response
    {
//        if (!$this->isGranted("ROLE_ADMIN")) {
//            return $this->redirectToRoute("home.index");
//        }

        if($this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('success', 'Bienvenue sur le profil '.$this->getUser()->getEmail());
        }
        return $this->render('profil/index.html.twig', [

        ]);
    }
    #[IsGranted("ROLE_ADMIN")]
    public function modifierProfil(): Response
    {
        if (!$this->isGranted("ROLE_ADMIN")) {
            return $this->redirectToRoute("home.index");
        }
        return $this->render('profil/index.html.twig', [

        ]);
    }
}
