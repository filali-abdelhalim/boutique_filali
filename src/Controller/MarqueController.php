<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Form\MarqueType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Form\Extension\Core\Type\TextType; 

use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarqueController extends AbstractController
{
    /**
     * @Route("/admin/marque", name="ajouter_marque")
     */
     
    public function index(Request $request):Response 
        {
            
            $marque = new Marque();
            $form = $this->createFormBuilder($marque)
                                
                    ->add('libelle_marque', TextType::class,
                    ["attr" => ["class" => "form-control"]])
                  
                    ->add('Ajouter', SubmitType::class, ['label' => 'Ajouter'])   
                    ->getForm();
    
            $form->handleRequest($request);
    
            if($form->isSubmitted() && $form->isValid()) 
            {
                $category = $form->getData();
    
                $em = $this->getDoctrine()->getManager();
    
                $em->persist($marque);
                $em->flush();
    
                
            }
            return $this->render('marque/ajouter.html.twig',["form" => $form->createView()]);
    
            
        }
}
