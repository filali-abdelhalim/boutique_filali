<?php

namespace App\Controller;


use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Extension\Core\Type\TextType; 
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CategorieController extends AbstractController
{
    /**
     * @Route("/admin/categorie", name="ajouter_categorie")
     * @param CategorieRepository $categorieRepository
     * @return Response
     */
    public function index(CategorieRepository $categorieRepository,Request $request):Response 
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

           
            }
            return $this->render('categorie/categorie.html.twig',["form" => $form->createView(),
            'categorie' => $categorieRepository->findAll()]);
              
        }

    /**
     * @Route("/admin/categorie/{id}/supprimer", name="supprimer_categorie")
     * @param Categorie $categorie
     * @return RedirectResponse
     */
    public function delete($id, Request $request): RedirectResponse
        {
            $repository = $this->getDoctrine()->getRepository(Categorie::class) ;
            $categorie = $repository->find($id);     

            $em = $this->getDoctrine()->getManager();
            $em->remove($categorie);
            $em->flush();

         return $this->redirectToRoute("ajouter_categorie");

        }

          
}
