<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted("ROLE_SUPER_ADMIN")]
class SuperAdminController extends AbstractController
{
    #[Route('/super/admin', name: 'app_super_admin')]
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
    #[Route('/{id}', name: 'update')]
    public function updateRole(EntityManagerInterface $em,Utilisateur $user){

        if($this->isGranted('ROLE_SUPER_ADMIN')){
            $user->setRoles(['ROLE_ADMIN']);
            $em->persist($user);
            $em->flush();
           return $this->redirectToRoute('app_super_admin');

        }
    }
}
