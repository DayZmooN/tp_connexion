<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted("ROLE_SUPER_ADMIN")]
#[Route('/super-admin', name: 'super-admin.')]
class SuperAdministrationController extends AbstractController
{
    #[Route('/{utilisateur}/ajout-super-administration', name: "ajouter")]
    public function index(Utilisateur $utilisateur, EntityManagerInterface $em): Response
    {
        $role_supp = "ROLE_ADMIN";
        $role_ajouter = "ROLE_SUPER_ADMIN";

        if (!in_array($role_ajouter, $utilisateur->getRoles())) {
            if (in_array($role_supp, $utilisateur->getRoles())) {
                $utilisateur->addRole($role_supp);
            }

            $utilisateur->addRole($role_ajouter);
            $em->persist($utilisateur);
            $em->flush();
            $this->addFlash('success', 'Ajout du rôle super admin pour ' . $utilisateur->getEmail());
        } else {
            $this->addFlash('danger', 'Le rôle super admin existe déjà pour ' . $utilisateur->getEmail());
        }

        return $this->redirectToRoute('app_utilisateur_index');
    }


    #[Route('retirer/{utilisateur}', name: 'delete-role')]
    public function deleteRole(Utilisateur $utilisateur, EntityManagerInterface $em, Request $request): Response
    {
        $role = $request->request->get('role'); // Récupérer le rôle à partir de la requête

        // Vérifie si le rôle existe dans les rôles de l'utilisateur avant de le supprimer
        if ($role && in_array($role, $utilisateur->getRoles())) {
            // Suppression du rôle
            $utilisateur->suppRole($role);
            $em->persist($utilisateur);
            $em->flush();

            $this->addFlash('success', 'Rôle retiré avec succès pour ' . $utilisateur->getEmail());
        } else {
            $this->addFlash('danger', 'Ce rôle n\'existe pas pour cet utilisateur');
        }

        return $this->redirectToRoute('app_utilisateur_index');
    }



}
