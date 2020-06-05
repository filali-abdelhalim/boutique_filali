<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;

use Symfony\Component\HttpFoundation\Request;

// use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class SecurityController extends AbstractController
{
    /**
     * @Route("/security", name="security_registration")
     */
    public function registration(Request $request, ManagerRegistry $managerRegistry,
     UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        //if ($user->id)
       

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) 
        {
            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);

            $em = $managerRegistry->getManager();

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute("security_login");
        }


        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(), ]);
    }
    /**
     * @Route("/connexion", name="security_login")
     */
    public function login()
    {
        return $this->render('security/login.html.twig');
    }
     /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout()
    {
      
    }
}
