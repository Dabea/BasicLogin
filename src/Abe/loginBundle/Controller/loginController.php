<?php

namespace Abe\loginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Abe\loginBundle\Form\UsersType;
use Abe\loginBundle\Entity\Users;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class loginController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Template()
     */
    public function loginAction(Request $request)
       
        {
         $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

        
    
        $user = new Users;
        $form = $this->createFormBuilder($user)
            ->add('username' , 'text')
            ->add('password' , 'password')
            ->add('login' , 'submit')
            ->getForm();
        return $this->render('AbeloginBundle:login:login.html.twig', array(
            'form' =>  $form->createView(),
            'last_username' => $lastUsername,
             'error'         => $error
        ));
    }

    /**
     * @Route("/main/update")
     * @Template()
     */
    public function updateAction()
    { 
    return $this->render('AbeloginBundle:login:secret.html.twig');
    }

    /**
     * @Route("/logout" , name="logout2")
     * @Template()
     */
    public function logoutAction()
    {
    }

    /**
     * @Route("/register")
     * @Template()
     */
    public function registerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = new Users;
        $form = $this->createForm(new UsersType(), $user);
         $form->handleRequest($request);
        if($form->isValid()){
            $em->persist($user);
            $em->flush();
        
        
        
        }
      return $this->render('AbeloginBundle:login:register.html.twig', array(
        'form' => $form->createView()
        
        
      ));
    
    
    
    
    }

    /**
     * @Route("/display")
     * @Template()
     */
    public function displayAction()
    {
    return $this->render('AbeloginBundle:login:register.html.twig');
    }
    
    /**
    * @Route("login_check" , name = "BlackMagic")
    */
    public function logincheckAction()
    {
        //caught by secury componet in symfony
    }
    
        /**
    * @Route("homepage" , name = "homepage")
    */
    public function homepageAction()
    {
        return $this->render('AbeloginBundle:login:homepage.html.twig');
    }

}
