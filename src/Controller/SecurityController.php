<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Client;
use App\Form\ClientType;
use App\Form\RegistrationType;

use App\Repository\ClientRepository;

// use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
    
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) 
        {
            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
            $user->setRoles(["ROLE_USER"]);

            $em = $managerRegistry->getManager();

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute("security_login");
        }


        return $this->render('security/registration.html.twig', ['form' => $form->createView() ]);
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

    // pour recupere toute les clients 
    /**
     * @Route("/client", name="client")
     */
    public function client(ClientRepository $clientRepository)
    {
       return $this->render('security/client.html.twig', [ 'client'=>$clientRepository->findAll() ]);
    }


    // pour recupere information client 
    /**
     * @Route("/{id}/infos", name="compte_infos")
     * @param UserRepository $userRepository
     * @return Response
     */
    public function client_infos($id, Request $request): Response
    {
      
        $repository = $this->getDoctrine()->getRepository(user::class) ;
        $compte = $repository->find($id); 

        // dd($compte);
       return $this->render('security/compte.html.twig', [ 'compte'=>$compte ]);
    }

     /**
     * @Route("admin/client/{id}/delete", name="client_delete")
     * @param UserRepository $userRepository
     */
    public function delete($id, Request $request)
    {

        $repository = $this->getDoctrine()->getRepository(user::class) ;
        $user = $repository->findOneBy(array('id'=>$id));     
        $em = $this->getDoctrine()->getManager();
       if( $em->remove($user)){
        
             $em->remove($user->getClient());
       };
         $em->flush();
     

        // echo'supprimer';

         return $this->redirectToRoute("client");
    }




}
