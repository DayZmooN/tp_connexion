<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/')]
class HomeController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(): Response
    {
        $user =$this->getUser();
        return $this->render('home/index.html.twig', [
            'users' => $user,

        ]);
    }

    #[Route('/change_locale/{locale}', name: 'change_locale')]
    public function changeLocale($locale, Request $request)
    {
        // On stocke la langue dans la session
        $request->getSession()->set('_locale', $locale);

        // On revient sur la page précédente
        return $this->redirect($request->headers->get('referer'));
    }



}
