<?php

namespace App\Controller;


use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Marque;
use App\Data\SearchData;


use App\Form\ArticleType;
use App\Form\CategorieType;
use App\Form\MarqueType;
use App\Form\SearchForm;


use App\Repository\ArticleRepository;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Form\Extension\Core\Type\TextType; 
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\HttpFoundation\RedirectResponse;
// use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\Doctrine\RegistryInterface;
// use Doctrine\ORM\EntityManagerInterface;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param ArticleRepository $articleRepository
     * @return Response 
     */
    public function home(ArticleRepository $articleRepository ,Request $request)
    {

        $data = new SearchData();
        // $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchForm::class, $data);

        $form->handleRequest($request);
        $categories = isset($_GET['categorie']) ? $_GET['categorie'] : [];
       
        
        if ($data->q !== null || $data->min !== null || $data->max !== null || $categories !== [] || $data->promo !== false ) {
            $articles = $articleRepository->findSearchArticles($data->q, $data->min, $data->max, $categories,$data->promo);
        } else {
            $articles = $articleRepository->findAll();
        }

                   
        return $this->render('article/affiche.html.twig', [ 'articles' => $articles,
        'form'=>$form->createView(), ] );
    }
   
          
     

    /**
     * @Route("/admin/article", name="ajouter_article")
     */
    public function index(Request $request): Response
    {
        

        $article = new Article();
        $form = $this->createFormBuilder($article)
                
        
                ->add('nom_art', TextType::class,
                ["attr" => ["class" => "form-control"]])
                
                ->add('prix_initial', MoneyType::class,
                ["attr" => ["class" => "form-control"]])

                ->add('promo', CheckboxType::class, 
                ['label' => 'En promotion',
                 'required' => false,])

                ->add('prix_final', MoneyType::class,
                ["attr" => ["class" => "form-control"]])

                ->add('description', TextareaType::class,
                ["attr" => ["class" => "form-control"]])

                ->add('image', TextType::class,
                ["attr" => ["class" => "form-control"]])

            
                ->add('categorie', EntityType::class,
                ['class' => Categorie::class,
                        
                'choice_label' => function($categorie, $key, $value) { 
                /** @var Categorie $categorie */ return ($categorie->getName());
                },
                ])
       

                ->add('marque', EntityType::class,  // deuxieme methode pour type choice label 
                ['class' => Marque::class,
                'choice_label' => function ($marque) {
                    return $marque->getLibelleMarque();
                },
                ])

            
                ->add('Ajouter', SubmitType::class, ['label' => 'Ajouter'])   
                ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) 
        {
            $article = $form->getData();

            $em = $this->getDoctrine()->getManager();

            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute("home");
           
        }
        return $this->render('article/ajouter.html.twig',["form" => $form->createView()]);

        
    }
  
    /**
     * @Route("/{id}/show", name="article_show")
     * @param Article $article
     * @param Request $request
     * @return Response
     */
    public function show($id, Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Article::class) ;
        $article = $repository->find($id); 

        return $this->render("article/show.html.twig", ["article" => $article]);
    }

     /**
     * @Route("admin/article/{id}/edit", name="article_edit")
     * @param Article $article
     * @param Request $request
     * @return Response
     */
    public function edit($id, Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Article::class) ;
        $article = $repository->find($id); 

        $form = $this->createForm(ArticleType::class, $article);
       
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute("home");
        }
        return $this->render("article/edit.html.twig", ["form" => $form->createView()]);
    }

    
    /**
     * @Route("admin/article/{id}/delete", name="article_delete")
     * @param Article $article
     * @return RedirectResponse
     */
    public function delete($id, Request $request): RedirectResponse
    {

        $repository = $this->getDoctrine()->getRepository(Article::class) ;
        $article = $repository->find($id);     

        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

         return $this->redirectToRoute("home");
    }

   
  
    
}
