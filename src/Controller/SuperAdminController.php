<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Entity\Utilisateur;
use App\Entity\Voiture;
use App\Repository\MarqueRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted("ROLE_SUPER_ADMIN")]
#[Route('/superadmin', name: 'super-admin.')]
class SuperAdminController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(UtilisateurRepository $utilisateurRepository): Response
    {

        if($this->isGranted('ROLE_SUPER_ADMIN')){
            $data=$utilisateurRepository->findAll();
            return $this->render('super_admin/index.html.twig', [
                'datas' => $data
            ]);

        }

        return $this->redirectToRoute('home.index');
    }




    #[Route('/super/admin/update/{id}', name: 'update')]
    public function updateRole(EntityManagerInterface $em,Utilisateur $user){

        if($this->isGranted('ROLE_SUPER_ADMIN')){
            $user->setRoles(['ROLE_ADMIN']);
            $em->persist($user);
            $em->flush();
           return $this->redirectToRoute('super-admin.index');

        }
        return $this->redirectToRoute('home.index');
    }

    #[Route('/super/admin/archive',name: 'archive.voiture')]
    public function archiveVoiture(VoitureRepository $voitureRepository,MarqueRepository $marqueRepository)
    {

        return $this->render('super_admin/archive_voiture.html.twig', [
            'voitures' => $voitureRepository->findVoitureDesactive(),
        ]);

    }

    #[Route('/super/admin/archive/marque',name: 'archive.marque')]
    public function archiveMarque(MarqueRepository $marqueRepository)
    {

        return $this->render('super_admin/marque.html.twig', [
            'marques'=> $marqueRepository->findDesactiveMarque()
        ]);

    }


    #[Route('/{id}/voiture/active', name: 'active')]
    public function archiveActive(Voiture $voiture, EntityManagerInterface $entityManager)
    {
        //  si la voiture est archivée
        if ($voiture->getArchive() === false) {
            $voiture->setArchive(true);
            $entityManager->persist($voiture);
            $this->addFlash('success', 'Voiture archivée avec succès.');
        }


        $entityManager->flush();

        return $this->redirectToRoute('super-admin.index');
    }


    #[Route('/{id}/marque/active', name: 'active.marque.voiture  ')]
    public function archiveMarqueActive(Voiture $voiture,Marque $marque, EntityManagerInterface $entityManager)
    {

        // Si la marque associée est archivée
        if ($marque->getArchive() === false) {
            // Réactiver la marque
            $marque->setArchive(true);
            $entityManager->persist($marque);

            //  toutes les voitures associées à cette marque
            foreach ($marque->getVoiture() as $voiture) {
                if (!$voiture->getArchive()) {
                    $voiture->setArchive(true);
                    $entityManager->persist($voiture);
                }
            }
        }

        $entityManager->flush();

        return $this->redirectToRoute('super-admin.archive.voiture');
    }







}
