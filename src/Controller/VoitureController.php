<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/voiture',name: 'user.voiture.')]
final class VoitureController extends AbstractController
{

    #[Route('',name: 'index', methods: ['GET'])]
    public function index(VoitureRepository $voitureRepository): Response
    {

        return $this->render('voiture/index.html.twig', [
            'voitures' => $voitureRepository->findVoitureActive(),
        ]);
    }


    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Voiture $voiture): Response
    {
        return $this->render('voiture/show.html.twig', [
            'voiture' => $voiture,
        ]);
    }

}





