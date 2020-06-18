<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Client;
use App\Form\ClientType;
use App\Form\RegistrationType;

use App\Repository\ClientRepository;

// use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
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
    /**
     * @Route("/client", name="client")
     */
    public function client(ClientRepository $clientRepository)
    {
       return $this->render('security/client.html.twig', [ 'client'=>$clientRepository->findAll() ]);
    }

     /**
     * @Route("admin/client/{id}/delete", name="client_delete")
     * @param UserRepository $userRepository
     * @return RedirectResponse
     */
    public function delete($id, Request $request): RedirectResponse
    {

        $repository = $this->getDoctrine()->getRepository(user::class) ;
        $user = $repository->findOneBy(array('id'=>$id));     
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        echo'supprimer';

         return new RedirectResponse ($this->redirectToRoute("client"));
    }




}
