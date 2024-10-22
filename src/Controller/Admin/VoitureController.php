<?php

namespace App\Controller\Admin;

use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
#[Route('/voiture',name: 'voiture.')]
final class VoitureController extends AbstractController
{
    //for user and admin route default to list
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(VoitureRepository $voitureRepository): Response
    {
        // Tous les rôles (SUPER_ADMIN, ADMIN et USER) voient les voitures actives
        if ($this->isGranted("ROLE_SUPER_ADMIN") || $this->isGranted("ROLE_ADMIN") || $this->isGranted("ROLE_USER")) {
            $voitures = $voitureRepository->findVoitureActive();
        } else {
            // Si l'utilisateur n'a pas de rôle valide
            $this->addFlash("error", "Veuillez vous connecter pour voir les voitures.");
            return $this->redirectToRoute('app_login');
        }

        return $this->render('voiture/index.html.twig', [
            'voitures' => $voitures,
        ]);
    }


    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/voiture/new', name: 'app_voiture_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $voiture->setArchive(true);
            $entityManager->persist($voiture);
            $entityManager->flush();

            return $this->redirectToRoute('voiture.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/voiture/new.html.twig', [
            'voiture' => $voiture,
            'form' => $form,
        ]);
    }

    #[Route('/admin/voiture/{id}', name: 'show', methods: ['GET'])]
    public function show(Voiture $voiture): Response
    {
        return $this->render('voiture/show.html.twig', [
            'voiture' => $voiture,
        ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/voiture/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Voiture $voiture, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('voiture.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/voiture/edit.html.twig', [
            'voiture' => $voiture,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('admin/voiture/{id}/delete', name: 'delete')]
    public function delete(Request $request, Voiture $voiture, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$voiture->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($voiture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('voiture.index', [], Response::HTTP_SEE_OTHER);
    }

}

