<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Entity\Media;
use App\Entity\Voiture;
use App\Form\MarqueType;
use App\Repository\MarqueRepository;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/marques')]
final class MarqueController extends AbstractController
{
    public function __construct(private readonly VoitureRepository $voitureRepository)
    {
    }

    #[Route(path:'',name: 'app_marque_index', methods: ['GET'])]
    public function index(MarqueRepository $marqueRepository): Response
    {

        return $this->render('marque/index.html.twig', [
            'marques' => $marqueRepository->findActiveMarque(),
        ]);
    }


    #[Route('/{id}', name: 'app_marque_show', methods: ['GET'])]
    public function show(Marque $marque, VoitureRepository $voitureRepository): Response
    {

        $voitures = $voitureRepository->findBy(['marque' => $marque]);
        return $this->render('marque/show.html.twig', [
            'marque' => $marque,
            'voitures' => $voitures,
        ]);
    }




//    #[IsGranted('ROLE_ADMIN')]
//    #[Route("/disable/{id}", name: 'app_marque_disable', methods: ['POST'])]
//    public function disable( Marque $marque, EntityManagerInterface $entityManager,VoitureRepository $voitureRepository): Response
//    {
//        $marque->setArchive(false);
//
//        $voitures =$this->voitureRepository->findBy(['marque'=>$marque]);
//
//        foreach ($voitures as $voiture) {
//            $voiture->setArchive(false);
//        }
//        $entityManager->persist($marque);
//        $entityManager->flush();
//
//        $this->addFlash('success','La marque et ses voiture on ete desactiver');
//
//        return $this->redirectToRoute('app_marque_index', [], Response::HTTP_SEE_OTHER);
//    }
}
