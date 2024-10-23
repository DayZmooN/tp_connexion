<?php


namespace App\Controller\profil;

use App\Form\ProfilType;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/profil',name: 'profil.')]
class EditProfilController extends AbstractController
{
    #[Route('/edit', name: 'edit')]
    public function index(Request $request,EntityManagerInterface $entityManager,UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $this->getUser();
        $form =$this->createForm(UtilisateurType::class,$user,['include_roles'=>false]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {

            $plainPassword =$form->get('password')->getData();
            if($plainPassword){
                $user->setPassword($passwordHasher->hashPassword($user,$plainPassword));
            }

            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Enregistrement réussi');
//            return $this->redirectToRoute('app_logout');
        }
        return $this->render('profil/edit.html.twig',[
            'user'=>$user,
            'form'=>$form->createView(),
        ]);
    }
}
