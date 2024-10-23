<?php

namespace App\Controller\Admin;

use App\Entity\Marque;
use App\Entity\Media;
use App\Form\MarqueType;
use App\Repository\MarqueRepository;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/marque')]
final class MarqueController extends AbstractController
{

    //same view user and admin
//    #[Route(name: 'app_marque_index', methods: ['GET'])]
//    public function index(MarqueRepository $marqueRepository): Response
//    {
//        return $this->render('marque/index.html.twig', [
//            'marques' => $marqueRepository->findAll(),
//        ]);
//    }

    #[Route('/new', name: 'app_marque_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $marque = new Marque();
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $infos =$form['media']->getData();
            if($infos){
            $media = new Media();
            $newMedia =uniqid().'.'.$infos->getExtension();
            $media->setChemin($newMedia);
            $media->setName($infos->getClientOriginalName());
            $media->setTaille($infos->getSize());
            $media->setExtension($infos->getMimeType());


                $infos->move(
                            "uploads/image",
                            $media->getName()
            );
            $marque->setMedia($media);
            $entityManager->persist($media);
            }
            $entityManager->persist($marque);
            $entityManager->flush();

            return $this->redirectToRoute('app_marque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/marque/new.html.twig', [
            'marque' => $marque,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_marque_show', methods: ['GET'])]
    public function show(Marque $marque): Response
    {
        return $this->render('marque/show.html.twig', [
            'marque' => $marque,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_marque_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Marque $marque, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $infos =$form['media']->getData();
            if($infos){
                if ($marque->getMedia())
                {
                    $oldMeda = 'uploads/image/'.$marque->getMedia()->getName();
                    if (file_exists($oldMeda)) {
                        unlink($oldMeda);
                    }
                }
                $media = $marque->getMedia()   ?:  new Media();
                $newMedia =uniqid().'.'.$infos->guessExtension();
                $media->setName($newMedia);
                $media->setTaille($infos->getSize());
                $media->setExtension($infos->getMimeType());
                $media->setChemin($infos->getClientOriginalName());

                $infos->move(
                    "uploads/image",
                    $newMedia
                );
                $marque->setMedia($media);
                if (!$media->getId()){
                    $entityManager->persist($media);
                }

            }

            $entityManager->flush();
            return $this->redirectToRoute('app_marque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/marque/edit.html.twig', [
            'marque' => $marque,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_marque_delete', methods: ['POST'])]
    public function delete(Request $request, Marque $marque, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$marque->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($marque);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_marque_index', [], Response::HTTP_SEE_OTHER);
    }


    #[IsGranted('ROLE_ADMIN')]
    #[Route("/disable/{id}", name: 'app_marque_disable', methods: ['POST'])]
    public function disable( Marque $marque, EntityManagerInterface $entityManager,VoitureRepository $voitureRepository): Response
    {
        $marque->setArchive(false);

        $voitures = $voitureRepository->findBy(['marque' => $marque]);

        foreach ($voitures as $voiture) {
            $voiture->setArchive(false);
            $entityManager->persist($voiture);
        }
        $entityManager->persist($marque);
        $entityManager->flush();

        $this->addFlash('success','La marque et ses voiture on ete desactiver');

        return $this->redirectToRoute('app_marque_index', [], Response::HTTP_SEE_OTHER);
    }
}
