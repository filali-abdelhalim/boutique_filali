<?php

namespace App\Controller;


use App\Entity\Categorie;
use App\Form\CategorieType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Form\Extension\Core\Type\TextType; 

use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CategorieController extends AbstractController
{
    /**
     * @Route("/admin/categorie", name="ajouter_categorie")
     */
    public function index(Request $request):Response 
        {
            
            $categorie = new Categorie();
            $form = $this->createFormBuilder($categorie)
                                
                    ->add('name', TextType::class,
                    ["attr" => ["class" => "form-control"]])
                  
                    ->add('Ajouter', SubmitType::class, ['label' => 'Ajouter'])   
                    ->getForm();
    
            $form->handleRequest($request);
    
            if($form->isSubmitted() && $form->isValid()) 
            {
                $category = $form->getData();
    
                $em = $this->getDoctrine()->getManager();
    
                $em->persist($categorie);
                $em->flush();

                // return $this->redirectToRoute("home");

                
            }
            return $this->render('categorie/ajouter.html.twig',["form" => $form->createView()]);
    
            
        }

      
}
