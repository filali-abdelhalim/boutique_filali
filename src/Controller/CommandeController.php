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
use Dompdf\Dompdf;
use Dompdf\Options;
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
          
            $client = $client_repo->findBy(array('user' => $user->getId()))[0];
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
        // dd($client,$commande,$facture);
   $session ->set('panierData', $panierData);   
    $session ->set('client', $client);  
     $session ->set('commande', $commande);  
      $session ->set('facture', $facture);  
        $session ->set('total', $total);   
         $session ->set('tva', $TVA);   
          $session ->set('generale', $totalGenerale);  
          
          
   $this->addFlash('generale', 'Paiement effectué');
  
     return $this->render('commande/facture.html.twig',
          ['articles' => $panierData,'client'=>$client, 'commande'=>$commande,'facture'=>$facture,'total'=> $total,
           'tva'=> $TVA, 'generale'=>$totalGenerale ]);
 
    }
  }

    /**
     * @Route("/facture", name="facture_print")
     */
    public function facture(SessionInterface $session)

    {

         $panierData =  $session ->get('panierData');
         $client = $session ->get('client');
         $commande = $session ->get('commande');
         $facture = $session ->get('facture');
         $total = $session ->get('total');
         $TVA = $session ->get('tva');
         $totalGenerale =  $session ->get('generale');
    
   /////
          $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // Retrieve the HTML generated in our twig file
        $html = $this->render('commande/facture_print.html.twig', [
            'articles' => $panierData,'client'=>$client, 'commande'=>$commande,'facture'=>$facture,'total'=> $total,'tva'=> $TVA, 'generale'=>$totalGenerale ]);
   //  dd($html);
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
         

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
         
    
         ////
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


