<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\User;
use App\Form\ProduitType;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/admin')]
class AdminController extends AbstractController
{
    //Consulteer la liste des utilisateurs
    #[Route('/users', name: 'app_admin_users')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $users = $doctrine->getRepository(User::class)->findAll();
        return $this->render('admin/ConsulterUser.html.twig', [
            'controller_name' => 'AdminController',
            'users'=>$users,
        ]);
    }

    //Ajouter un user a la liste des utilisateurs
    #[Route('/users/ajout', name: 'app_admin_users_ajout')]
    public function UsersAjout(ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plaintextPassword = $form->get('password')->getData();
            $hashedPassword = $userPasswordHasher->hashPassword(
                $user,
                $plaintextPassword
            );

            $user->setPassword($hashedPassword);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_users');
        }

        return $this->render('admin/AjoutUsers.html.twig', [
            'controller_name' => 'AdminController',
            'form' => $form->createView(),
        ]);
    }

    //Modifier un user du liste des utilisateurs
    #[Route('/users/modifier/{id}', name: 'app_admin_users_modifier')]
    public function UsersModifier(ManagerRegistry $doctrine, Request $request,User $user, UserPasswordHasherInterface $userPasswordHasher): Response
    {

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plaintextPassword = $form->get('password')->getData();
            $hashedPassword = $userPasswordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_users');
        }
        return $this->render('admin/ModifierUsers.html.twig', [
            'controller_name' => 'AdminController',
            'user'=>$user,
            'form' => $form->createView(),
        ]);
    }

    //Supprimer un user du liste des utilisateurs
    #[Route('/users/supp/{id}', name: 'app_admin_users_supprimer')]
    public function UsersSupprimer(ManagerRegistry $doctrine, Request $request,User $user)
    {  
        $em = $doctrine->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('app_admin_users');
    }


       //Consulteer la liste des produits
       #[Route('/produits', name: 'app_admin_produits')]
       public function produits(ManagerRegistry $doctrine): Response
       {
   
           $produits = $doctrine->getRepository(Produit::class)->findAll();
           return $this->render('admin/ConsulterProduits.html.twig', [
               'controller_name' => 'AdminController',
               'produits'=>$produits,
           ]);
       }
   
       //Ajouter un user a la liste des produits
       #[Route('/produits/ajout', name: 'app_admin_produits_ajout')]
       public function produitsAjout(ManagerRegistry $doctrine, Request $request): Response
       {
           $produits = new Produit();
           $form = $this->createForm(ProduitType::class, $produits);
           $form->handleRequest($request);
   
           if ($form->isSubmitted() && $form->isValid()) {
               $entityManager = $doctrine->getManager();
               $entityManager->persist($produits);
               $entityManager->flush();
   
               return $this->redirectToRoute('app_admin_produits');
           }
   
           return $this->render('admin/AjoutProduits.html.twig', [
               'controller_name' => 'AdminController',
               'form' => $form->createView(),
           ]);
       }
   
       //Modifier un user du liste des produits
       #[Route('/produits/modifier/{id}', name: 'app_admin_produits_modifier')]
       public function produitsModifier(ManagerRegistry $doctrine, Request $request,Produit $produit): Response
       {
   
           $form = $this->createForm(ProduitType::class, $produit);
           $form->handleRequest($request);
   
           if ($form->isSubmitted() && $form->isValid()) {
               $entityManager = $doctrine->getManager();
               $entityManager->persist($produit);
               $entityManager->flush();
   
               return $this->redirectToRoute('app_admin_produits');
           }
           return $this->render('admin/ModifierProduits.html.twig', [
               'controller_name' => 'AdminController',
               'produit'=>$produit,
               'form' => $form->createView(),
           ]);
       }
   
       //Supprimer un user du liste des produits
       #[Route('/produits/supp/{id}', name: 'app_admin_produits_supprimer')]
       public function produitSupprimer(ManagerRegistry $doctrine, Request $request,Produit $produit)
       {  
           $em = $doctrine->getManager();
           $em->remove($produit);
           $em->flush();
           return $this->redirectToRoute('app_admin_produits');
       }
   


}
