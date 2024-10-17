<?php

namespace App\Controller;

use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin',methods: ['GET'])]
    public function index(ObjectRepository $objectRepo): Response
    {

        if ($this->isGranted('ROLE_ADMIN')|| $this->isGranted('ROLE_SUPER_ADMIN')) {
            $text="je suis dispo uniquement pour les admins";
            $user =$this->getUser();

            return $this->render('admin/index.html.twig',[
                'text'=>$text,
                'user'=>$user,
                'objects'=>$objectRepo->findAll()
            ]);

        }else{
            return $this->redirectToRoute('home.index');
        }

    }
}
