<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\User;
use App\Entity\Produit;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;



class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }

    #[Route('/recherche/{rech}', name: 'app_recherche')]

    public function Recherche(ManagerRegistry $doctrine, String $rech): Response
    {

        $users = $doctrine->getRepository(User::class)->findByNom($rech);
        $produits = $doctrine->getRepository(Produit::class)->findByNom($rech);
        dump($users);
        dump($produits);die;
        return $this->render('dashboard/recherche.html.twig', [
            'users' => $users,
        ]);
    }
}
