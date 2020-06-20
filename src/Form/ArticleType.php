<?php

namespace App\Form;

use App\Entity\Marque;
use App\Entity\Article;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType; 
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 


class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                
        
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

                ->add('imageFile',FileType::class,['required'=>false])


                // ->add('image', TextType::class,
                // ["attr" => ["class" => "form-control"]])

            
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
                ]);

            
              //  ->add('Ajouter', SubmitType::class, ['label' => 'Ajouter']); 
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
