<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Form\MarqueType;
use App\Repository\MarqueRepository;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Extension\Core\Type\TextType; 
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MarqueController extends AbstractController
{
    /**
     * @Route("/admin/marque", name="ajouter_marque")
     * @param MarqueRepository $marqueRepository
     * @return Response
     */
     
    public function index(Request $request,MarqueRepository $marqueRepository):Response 
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
            return $this->render('marque/marque.html.twig',["form" => $form->createView(),
            'marque' => $marqueRepository->findAll()]);
    
            
        }
    /**
     * @Route("/admin/marque/{id}/supprimer", name="supprimer_marque")
     * @param Marque $marque
     * @return RedirectResponse
     */
    public function delete($id, Request $request): RedirectResponse
        {
            $repository = $this->getDoctrine()->getRepository(Marque::class) ;
            $marque = $repository->find($id);     

            $em = $this->getDoctrine()->getManager();
            $em->remove($marque);
            $em->flush();

         return $this->redirectToRoute("ajouter_marque");

        }
}
