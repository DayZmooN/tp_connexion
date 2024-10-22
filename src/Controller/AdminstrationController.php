<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted("ROLE_ADMIN")]
#[Route('/utilisateur', name:'user.')]
class AdminstrationController extends AbstractController
{
    #[Route('/{utilisateur}/ajout_admin',name:'ajoutAdmin')]
    public function index(Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        $role_ajouter ="ROLE_ADMIN";
        if(!in_array("ROLE_ADMIN",$utilisateur->getRoles())){
            $utilisateur->addRole($role_ajouter);
            $entityManager->persist($utilisateur);
            $entityManager->flush();
            $this->addFlash("success","Ajouty du role admn est ok");
        }else{
            $this->addFlash('warning',"Le  role admin  existe deja, pas rajouté");
        }
        return $this->redirectToRoute('app_utilisateur_index');
    }
}
