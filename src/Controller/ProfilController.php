<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/profil', name: 'profil.')]
class ProfilController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(): Response
    {

        return $this->render('profil/index.html.twig', [

        ]);
    }
}