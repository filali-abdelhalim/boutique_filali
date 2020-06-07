<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $user = new User();
        // dd($user);

       
       
        $builder
            ->add('email')
            ->add('username')
            ->add('password' , PasswordType::class)
            ->add('confirme_password', PasswordType::class)
            ->add('client', ClientType::class);
            

            // ->add('roles', ChoiceType::class, [
            //     'choices'  => [
            //         'Role Admin' => true,
            //         'Role user' => true, 
            //     ],
               
            // ]);

             if ($user->getId() !==  null) {
              $builder->add('roles', ChoiceType::class, [
                'choices'  => [
                    'Role Admin' => true,
                    'Role user' => true, 
                ],
               
            ]);
            
        }
       
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
