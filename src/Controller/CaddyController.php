<?php

namespace App\Controller;

use App\Repository\ArticleRepository;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;



class CaddyController extends AbstractController
{
    /**
     * @Route("/caddy", name="caddy")
     */
    public function index(SessionInterface $session , ArticleRepository $articleRepository)
    {
        $panier = $session->get('panier',[]);

        $panierData = [];

        foreach($panier as $id=> $quantité)
        {
          $panierData []= ['article' => $articleRepository->find($id), 'quantité' => $quantité ];
        }

        $total = 0;
        foreach($panierData as $item)
        {
         $totalPanier = $item['article']->getPrixInitial() * $item['quantité'];
         $total += $totalPanier;
        }
        $TVA = $total * 20/100 ;
        $totalGenerale = $total + $TVA; 

        // dump($panierData);
        // dump($total) ;
        // exit();

        return $this->render('caddy/panier.html.twig', ['panier' => $panierData, 'total'=> $total,
         'tva'=> $TVA, 'generale'=>$totalGenerale]);
    }

    /**
     * @Route("/caddy/add/{id}", name="caddy_add")
     * @return Response 
     * @return Request
     */
    public function add($id , SessionInterface $session,Request $request) :Response
    {
     // /caddy
     $route =substr($request->get('redirect'),1); // pour recuperer les parametre de url pour rediger ver la meme page
     if (empty($route) )
     {
       $route = "home";
     }
      $panier = $session->get('panier',[]);

        if (!empty($panier[$id]))
        {
          $panier[$id]++;
        }
        else
        {
            $panier[$id] = 1;
        }

      $session ->set('panier', $panier);
     return $this->redirectToRoute($route);

        // return $this->render('caddy/index.html.twig', ['panier' => $session,]);
    }
    
    /**
     * @Route("/caddy/remove/{id}", name="caddy_remove")
     * @return Response 
     */
    public function remouve($id , SessionInterface $session) :Response
    {

      $panier = $session->get('panier',[]);

        if (!empty($panier[$id]))
        {
          unset($panier[$id]);
        }
        

      $session ->set('panier', $panier);

      return $this->redirectToRoute("caddy");

    }
    
    /**
     * @Route("/caddy/supp/{id}", name="caddy_supprime")
     * @return Response 
     */
    public function supprime($id , SessionInterface $session) :Response
    {

      $panier = $session->get('panier',[]);

        if (!empty($panier[$id]) && $panier[$id] > 1)
        {
          $panier[$id]--;
        }
       else
       {
         unset($panier[$id]);
       }

      $session ->set('panier', $panier);

      return $this->redirectToRoute("caddy");

    }


}
