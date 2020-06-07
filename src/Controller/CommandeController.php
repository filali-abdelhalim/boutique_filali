<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Client;
use App\Entity\Article;
use App\Entity\Facture;
use App\Entity\Commande;
use App\Repository\ClientRepository;
use App\Repository\ArticleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{
    /**
     * @Route("/commande", name="commande_payer")
     */
    public function index(SessionInterface $session, ArticleRepository $articleRepository,ClientRepository $client_repo )
    {
        if ( !$this->getUser() ) {
            return $this->redirectToRoute("security_login");
        }
    
     
     
      $user = $this->getUser();
    
      
       $panier = $session->get('panier',[]);
       $facture  = new Facture();
        if (!empty($panier)) {
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
        $facture->setApayer($totalGenerale);
        $facture->setpayee($totalGenerale);
          $em = $this->getDoctrine()->getManager();

            $em->persist($facture);
            $em->flush();
          
           
            $client = $client_repo->find($user->getId());
            $commande = new Commande();
            $commande->setClient($client);
            $commande->setFacture($facture);
            $commande->setDateCmd(new \DateTime());
            $commande->setLivree(1);
                   
            $em->persist($commande);
           
            $em->flush();
  foreach($panier as $id=> $quantité)
        {
          $article=  $articleRepository->find($id);
          $article->setCommande($commande);
          $em->persist($article);
            $em->flush();

            // var_dump($article);

        }
        // $session->set('panier',[]);   pour vide le panier apres l'achat
        dd('sortie');
        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }
  }
}
//  on a fait jointure entre commande et article
 // on a fait jointure entre commande et client 
 // on a fait jointure entre commande et facture
// Premiere etape: creer une nouvelle facture pour recueper l'id pour l'utiliser dans commande

// deuxieme etape: recuperer id user pour recuperer l'objet client associe
// troisieme etape: creer la commande: 
// quatrieme  etape:metre ajour l'article avec Objet Commande

// Prochaine etape:  modifier l'entité Client:  Retirer le username+ password  ok
// quand tu clic sur Commander tester si le user est connecté ,connecte toi et affiche un formulaire a remplir qui contient:
     /* (XX) - email
    nom_cli
    prenom_cli
    date_de_naissance 
    `adresse`
    `ville
    `cp
    telephone
  */
  // valide ton formulaire et passe à l'etape dre paielent
  // si un nouveau client ,appeler la route (security_register) et s'scrire puis reviens sur l'etape // XX

///  Apres payer/commander , afficher un Twig  le recaptulatif de la commande (facture)
// quand tu fais le twig, yu utilise un b_ndle qui converti le html to pdf
//https://www.grafikart.fr/forum/topics/30950


